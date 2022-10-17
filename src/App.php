<?php

declare(strict_types=1);

namespace Fi1a\Console;

use Fi1a\Console\Definition\Definition;
use Fi1a\Console\Definition\DefinitionValidator;
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
        $definition->addOption('colors', 'cl')
            ->default('ansi');

        $instance = null;
        if ($command) {
            if (!is_subclass_of($command, CommandInterface::class)) {
                throw new InvalidArgumentException('The class must implement the interface ' . CommandInterface::class);
            }
            $instance = new $command($definition);
        }

        $valueSetter = new ValueSetter($definition, $input);
        try {
            $valueSetter->setValues();
        } catch (ValueSetterException $exception) {
            $output->getErrorOutput()->writeln('<error>' . $exception->getMessage() . '</error>');

            return 1;
        }
        $definitionValidator = new DefinitionValidator($definition);
        $result = $definitionValidator->validate();
        if (!$result->isSuccess()) {
            /**
             * @var Error $error
             */
            foreach ($result->getErrors() as $error) {
                $message = (string) $error->getMessage();
                $output->getErrorOutput()->writeln('<error>' . $message . '</error>');
            }

            return 1;
        }
        assert($instance instanceof CommandInterface);

        return $instance->run($input, $output, $stream, $definition);
    }
}
