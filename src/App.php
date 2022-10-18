<?php

declare(strict_types=1);

namespace Fi1a\Console;

use Fi1a\Console\Command\InfoCommand;
use Fi1a\Console\Definition\Definition;
use Fi1a\Console\Definition\DefinitionValidator;
use Fi1a\Console\Definition\EntityInterface;
use Fi1a\Console\Definition\Exception\ValueSetterException;
use Fi1a\Console\Definition\ValueSetter;
use Fi1a\Console\IO\ArgvInputArguments;
use Fi1a\Console\IO\ConsoleInput;
use Fi1a\Console\IO\ConsoleOutput;
use Fi1a\Console\IO\ConsoleOutputInterface;
use Fi1a\Console\IO\Formatter;
use Fi1a\Console\IO\InputArgumentsInterface;
use Fi1a\Console\IO\InputInterface;
use Fi1a\Console\IO\Style\ANSIStyle;
use Fi1a\Console\IO\Style\ExtendedStyle;
use Fi1a\Console\IO\Style\TrueColorStyle;
use Fi1a\Validation\Error;
use InvalidArgumentException;

/**
 * Консольное приложение
 */
class App implements AppInterface
{
    /**
     * @var InputArgumentsInterface|null
     */
    private $input;

    /**
     * @var ConsoleOutputInterface|null
     */
    private $output;

    /**
     * @var InputInterface|null
     */
    private $stream;

    /**
     * @var string[]
     */
    private $commands = [];

    /**
     * @inheritDoc
     */
    public function __construct(
        ?InputArgumentsInterface $input = null,
        ?ConsoleOutputInterface $output = null,
        ?InputInterface $stream = null
    ) {
        $this->input = $input;
        $this->output = $output;
        $this->stream = $stream;

        $this->addCommand('info', InfoCommand::class);
    }

    /**
     * @inheritDoc
     */
    public function run(?string $command = null): int
    {
        $input = $this->input;
        // @codeCoverageIgnoreStart
        if (is_null($input)) {
            $input = new ArgvInputArguments(Registry::getArgv());
        }
        $output = $this->output;
        if (is_null($output)) {
            $output = new ConsoleOutput(new Formatter(ANSIStyle::class));
        }
        $stream = $this->stream;
        if (is_null($stream)) {
            $stream = new ConsoleInput();
        }
        // @codeCoverageIgnoreEnd

        $definition = new Definition();

        $definition->addOption('colors', 'c')
            ->default('ansi')
            ->validation()
            ->allOf()
            ->in('ansi', 'ext', 'trueColor', 'none');

        $definition->addOption('verbose', 'v')
            ->default('normal')
            ->validation()
            ->allOf()
            ->in('none', 'normal', 'hight', 'hightest', 'debug');

        if ($command) {
            if (!is_subclass_of($command, CommandInterface::class)) {
                throw new InvalidArgumentException('Класс должен реализовывать интерфейс ' . CommandInterface::class);
            }
        } else {
            $tokens = $input->getTokens();
            $commandName = reset($tokens);
            if (!$commandName || substr($commandName, 0, 1) === '-') {
                $commandName = 'info';
            } else {
                $tokens = array_slice($tokens, 1);
            }
            $input->setTokens($tokens);
            $command = $this->getCommand($commandName);
            if ($command === false) {
                $output->getErrorOutput()->writeln(
                    'Команда "{{commandName}}" не найдена',
                    ['commandName' => $commandName],
                    'error'
                );

                return 1;
            }
        }
        /** @psalm-suppress InvalidStringClass */
        $instance = new $command($definition);

        $valueSetter = new ValueSetter($definition, $input);
        try {
            $valueSetter->setValues();
        } catch (ValueSetterException $exception) {
            $output->getErrorOutput()->writeln($exception->getMessage(), [], 'error');

            return 1;
        }

        $colorsOption = $definition->getOption('colors');
        assert($colorsOption instanceof EntityInterface);
        switch (mb_strtolower((string) $colorsOption->getValue())) {
            case 'ext':
                $output->setFormatter(new Formatter(ExtendedStyle::class));

                break;
            case 'truecolor':
                $output->setFormatter(new Formatter(TrueColorStyle::class));

                break;
            case 'ansi':
                $output->setFormatter(new Formatter(ANSIStyle::class));

                break;
            case 'none':
                $output->setDecorated(false);

                break;
            default:
                $output->getErrorOutput()->writeln(
                    'Доступные значения для опции --colors (none, ansi, ext, trueColor)',
                    [],
                    'error'
                );

                return 1;
        }

        $verboseOption = $definition->getOption('verbose');
        assert($verboseOption instanceof EntityInterface);
        $verbose = [
            'none' => ConsoleOutputInterface::VERBOSE_NONE,
            'normal' => ConsoleOutputInterface::VERBOSE_NORMAL,
            'hight' => ConsoleOutputInterface::VERBOSE_HIGHT,
            'hightest' => ConsoleOutputInterface::VERBOSE_HIGHTEST,
            'debug' => ConsoleOutputInterface::VERBOSE_DEBUG,
        ];
        if (!array_key_exists(mb_strtolower((string) $verboseOption->getValue()), $verbose)) {
            $output->getErrorOutput()->writeln(
                'Доступные значения для опции --verbose (none, normal, hight, hightest, debug)',
                [],
                'error'
            );

            return 1;
        }
        $output->setVerbose($verbose[mb_strtolower((string) $verboseOption->getValue())]);

        $definitionValidator = new DefinitionValidator($definition);
        $result = $definitionValidator->validate();
        if (!$result->isSuccess()) {
            /**
             * @var Error $error
             */
            foreach ($result->getErrors() as $error) {
                $message = (string) $error->getMessage();
                $output->getErrorOutput()->writeln($message, [], 'error');
            }

            return 1;
        }

        assert($instance instanceof CommandInterface);

        return $instance->run($input, $output, $stream, $definition, $this);
    }

    /**
     * @inheritDoc
     */
    public function addCommand(string $name, string $command): AppInterface
    {
        if (!$name) {
            throw new InvalidArgumentException('Аргумент $name не может быть пустым');
        }
        if (!is_subclass_of($command, CommandInterface::class)) {
            throw new InvalidArgumentException('Класс должен реализовывать интерфейс ' . CommandInterface::class);
        }
        if ($this->hasCommand($name)) {
            throw new InvalidArgumentException(sprintf('Команда с именем "%s" уже имеется', $name));
        }

        $this->commands[$name] = $command;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function hasCommand(string $name): bool
    {
        if (!$name) {
            throw new InvalidArgumentException('Аргумент $name не может быть пустым');
        }

        return array_key_exists(mb_strtolower($name), $this->commands);
    }

    /**
     * @inheritDoc
     */
    public function getCommand(string $name)
    {
        if (!$name) {
            throw new InvalidArgumentException('Аргумент $name не может быть пустым');
        }
        if (!$this->hasCommand($name)) {
            return false;
        }

        return $this->commands[mb_strtolower($name)];
    }

    /**
     * @inheritDoc
     */
    public function deleteCommand(string $name): bool
    {
        if (!$name) {
            throw new InvalidArgumentException('Аргумент $name не может быть пустым');
        }
        if (!$this->hasCommand($name)) {
            return false;
        }
        unset($this->commands[mb_strtolower($name)]);

        return true;
    }

    /**
     * @inheritDoc
     */
    public function allCommands(): array
    {
        return $this->commands;
    }
}
