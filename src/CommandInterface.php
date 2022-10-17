<?php

declare(strict_types=1);

namespace Fi1a\Console;

use Fi1a\Console\Definition\DefinitionInterface;
use Fi1a\Console\IO\ConsoleOutputInterface;
use Fi1a\Console\IO\InputArgumentsInterface;
use Fi1a\Console\IO\InputInterface;

/**
 * Интерфейс команды
 */
interface CommandInterface
{
    /**
     * Конструктор
     */
    public function __construct(DefinitionInterface $definition);

    /**
     * Запускает команду на выполнение
     */
    public function run(
        InputArgumentsInterface $input,
        ConsoleOutputInterface $output,
        InputInterface $stream,
        DefinitionInterface $definition,
        AppInterface $app
    ): int;

    /**
     * Возвращает информацию по команде
     */
    public function label(): string;
}
