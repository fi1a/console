<?php

declare(strict_types=1);

namespace Fi1a\Console;

use Fi1a\Console\IO\ConsoleOutputInterface;
use Fi1a\Console\IO\InputArgumentsInterface;
use Fi1a\Console\IO\InputInterface;

interface AppInterface
{
    /**
     * Конструктор
     */
    public function __construct(
        ?InputArgumentsInterface $input = null,
        ?ConsoleOutputInterface $output = null,
        ?InputInterface $stream = null
    );

    /**
     * Запуск комманды
     */
    public function run(?string $command = null): int;

    /**
     * Добавить комманду
     *
     * @return static
     */
    public function addCommand(string $name, string $command): AppInterface;

    /**
     * Наличие комманды с таким именем
     */
    public function hasCommand(string $name): bool;

    /**
     * Возвращает класс команды с таким именем
     *
     * @return string|false
     */
    public function getCommand(string $name);

    /**
     * Удаление комманды с таким именем
     */
    public function deleteCommand(string $name): bool;
}
