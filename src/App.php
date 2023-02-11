<?php

declare(strict_types=1);

namespace Fi1a\Console;

use Fi1a\Console\Command\InfoCommand;
use Fi1a\Console\Definition\Definition;
use Fi1a\Console\Definition\DefinitionValidator;
use Fi1a\Console\Definition\Exception\ValueSetterException;
use Fi1a\Console\Definition\ValueSetter;
use Fi1a\Console\IO\ConsoleOutputInterface;
use Fi1a\Console\IO\EntityInterface;
use Fi1a\Console\IO\Formatter;
use Fi1a\Console\IO\InputArgumentsInterface;
use Fi1a\Console\IO\InputInterface;
use Fi1a\Console\IO\Style\ANSIStyle;
use Fi1a\Console\IO\Style\ExtendedStyle;
use Fi1a\Console\IO\Style\TrueColorStyle;
use Fi1a\Validation\Error;
use InvalidArgumentException;

use const PHP_EOL;

/**
 * Консольное приложение
 */
class App implements AppInterface
{
    /**
     * @var InputArgumentsInterface
     */
    private $input;

    /**
     * @var ConsoleOutputInterface
     */
    private $output;

    /**
     * @var InputInterface
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
        if ($input === null) {
            /** @var InputArgumentsInterface $input */
            $input = di()->get(InputArgumentsInterface::class);
        }
        $this->input = $input;
        if ($output === null) {
            /** @var ConsoleOutputInterface $output */
            $output = di()->get(ConsoleOutputInterface::class);
        }
        $this->output = $output;
        if ($stream === null) {
            /** @var InputInterface $stream */
            $stream = di()->get(InputInterface::class);
        }
        $this->stream = $stream;

        $this->addCommand('info', InfoCommand::class);
    }

    /**
     * @inheritDoc
     */
    public function run(?string $command = null): int
    {
        $definition = new Definition();

        $definition->addOption('colors', 'c')
            ->default('ansi')
            ->description(
                'Используемый цвет в консоли.' . PHP_EOL
                . 'Возможные значения: none, ansi, ext, trueColor.'
            )
            ->validation()
            ->allOf()
            ->in('ansi', 'ext', 'trueColor', 'none');

        $definition->addOption('verbose', 'v')
            ->default('normal')
            ->description(
                'Определяет уровень подробности вывода сообщений при работе консольных команд.' . PHP_EOL
                . 'Возможные значения: none, normal, hight, hightest, debug.'
            )
            ->validation()
            ->allOf()
            ->in('none', 'normal', 'hight', 'hightest', 'debug');

        $definition->addOption('help', 'h')
            ->default(false)
            ->description('Справка по выбранной команде.')
            ->validation()
            ->allOf()
            ->boolean();

        $commandName = null;

        if ($command) {
            if (!is_subclass_of($command, CommandInterface::class)) {
                throw new InvalidArgumentException('Класс должен реализовывать интерфейс ' . CommandInterface::class);
            }
        } else {
            $tokens = $this->input->getTokens();
            $commandName = reset($tokens);
            if (!$commandName || substr($commandName, 0, 1) === '-') {
                $commandName = 'info';
            } else {
                $tokens = array_slice($tokens, 1);
            }
            $this->input->setTokens($tokens);
            $command = $this->getCommand($commandName);
            if ($command === false) {
                $this->output->getErrorOutput()->writeln(
                    'Команда "{{commandName}}" не найдена',
                    ['commandName' => $commandName],
                    'error'
                );

                return 1;
            }
        }
        /** @psalm-suppress InvalidStringClass */
        $instance = new $command($definition);
        assert($instance instanceof CommandInterface);

        $valueSetter = new ValueSetter($definition, $this->input);
        try {
            $valueSetter->setValues();
        } catch (ValueSetterException $exception) {
            $this->output->getErrorOutput()->writeln($exception->getMessage(), [], 'error');

            return 1;
        }

        $colorsOption = $definition->getOption('colors');
        assert($colorsOption instanceof EntityInterface);
        switch (mb_strtolower((string) $colorsOption->getValue())) {
            case 'ext':
                $this->output->setFormatter(new Formatter(ExtendedStyle::class));

                break;
            case 'truecolor':
                $this->output->setFormatter(new Formatter(TrueColorStyle::class));

                break;
            case 'ansi':
                $this->output->setFormatter(new Formatter(ANSIStyle::class));

                break;
            case 'none':
                $this->output->setDecorated(false);

                break;
            default:
                $this->output->getErrorOutput()->writeln(
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
            $this->output->getErrorOutput()->writeln(
                'Доступные значения для опции --verbose (none, normal, hight, hightest, debug)',
                [],
                'error'
            );

            return 1;
        }
        $this->output->setVerbose($verbose[mb_strtolower((string) $verboseOption->getValue())]);

        $helpOption = $definition->getOption('help');
        assert($helpOption instanceof EntityInterface);
        /**
         * @var bool|string $helpValue
         */
        $helpValue = $helpOption->getValue();
        if (is_string($helpValue)) {
            $helpValue = mb_strtolower($helpValue);
        }
        if (in_array($helpValue, ['y', true, '1', 1])) {
            return $instance->help(
                $this->input,
                $this->output,
                $this->stream,
                $definition,
                $this,
                $commandName
            );
        }

        $definitionValidator = new DefinitionValidator($definition);
        $result = $definitionValidator->validate();
        if (!$result->isSuccess()) {
            /**
             * @var Error $error
             */
            foreach ($result->getErrors() as $error) {
                $message = (string) $error->getMessage();
                $this->output->getErrorOutput()->writeln($message, [], 'error');
            }

            return 1;
        }

        return $instance->run(
            $this->input,
            $this->output,
            $this->stream,
            $definition,
            $this
        );
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
