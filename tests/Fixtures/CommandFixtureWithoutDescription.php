<?php

declare(strict_types=1);

namespace Fi1a\Unit\Console\Fixtures;

use Fi1a\Console\AppInterface;
use Fi1a\Console\Definition\DefinitionInterface;
use Fi1a\Console\IO\ConsoleOutputInterface;
use Fi1a\Console\IO\InputArgumentsInterface;
use Fi1a\Console\IO\InputInterface;

/**
 * Команда
 */
class CommandFixtureWithoutDescription extends \Fi1a\Console\AbstractCommand
{
    /**
     * @inheritDoc
     */
    public function __construct(DefinitionInterface $definition)
    {
        $definition->addOption('option1')
            ->description('Тестовая опция')
            ->validation()
            ->allOf()
            ->integer();

        $definition->addArgument('arg1')->description('Тестовый аргумент 1');
        $definition->addArgument('arg2')->description('Тестовый аргумент 2');
    }

    /**
     * @inheritDoc
     */
    public function run(
        InputArgumentsInterface $input,
        ConsoleOutputInterface $output,
        InputInterface $stream,
        DefinitionInterface $definition,
        AppInterface $app
    ): int {
        return 0;
    }
}
