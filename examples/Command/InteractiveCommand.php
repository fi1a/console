<?php

declare(strict_types=1);

namespace Fi1a\Console\Examples\Command;

use Fi1a\Console\AbstractCommand;
use Fi1a\Console\AppInterface;
use Fi1a\Console\Definition\DefinitionInterface;
use Fi1a\Console\IO\ConsoleOutputInterface;
use Fi1a\Console\IO\InputArgumentsInterface;
use Fi1a\Console\IO\InputInterface;
use Fi1a\Console\IO\InteractiveInput;

/**
 * Интерактивный ввод
 */
class InteractiveCommand extends AbstractCommand
{
    /**
     * @inheritDoc
     */
    public function __construct(DefinitionInterface $definition)
    {
    }

    /**
     * @inheritDoc
     * @psalm-suppress PossiblyFalseReference
     * @psalm-suppress MixedMethodCall
     */
    public function run(
        InputArgumentsInterface $input,
        ConsoleOutputInterface $output,
        InputInterface $stream,
        DefinitionInterface $definition,
        AppInterface $app
    ): int {
        $output->writeln(['', '<option=bold>Интерактивный ввод</>', '']);

        $interactive = new InteractiveInput($output, $stream);

        $interactive->addValue('foo')
            ->description('Введите количество от 1 до 10')
            ->validation()
            ->allOf()
            ->min(1)
            ->max(10);

        $bar = $interactive->addValue('bar')
            ->description('Введите строки длиной от 2-х символов')
            ->multiple();

        $bar->multipleValidation()
            ->allOf()
            ->minCount(1)
            ->required();

        $bar->validation()
            ->allOf()
            ->minLength(2);

        $interactive->addValue('baz')
            ->description('Согласны (y/n)')
            ->validation()
            ->allOf()
            ->boolean();

        $interactive->read();

        // Доступ к введенным значениям
        $output->writeln((string) $interactive->getValue('foo')->getValue());
        $output->writeln((string) count((array) $interactive->getValue('bar')->getValue()));
        $output->writeln((string) $interactive->getValue('baz')->getValue());

        return 0;
    }

    /**
     * @inheritDoc
     */
    public function description(): ?string
    {
        return 'Интерактивный ввод';
    }
}
