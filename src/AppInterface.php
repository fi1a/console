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
     * Запуск команды
     */
    public function run(?string $command = null): int;

    /**
     * Добавить команду
     *
     * @return static
     */
    public function addCommand(string $name, string $command): AppInterface;

    /**
     * Наличие команды с таким именем
     */
    public function hasCommand(string $name): bool;

    /**
     * Возвращает класс команды с таким именем
     *
     * @return string|false
     */
    public function getCommand(string $name);

    /**
     * Удаление команды с таким именем
     */
    public function deleteCommand(string $name): bool;

    /**
     * Возвращает все добавленные команды
     *
     * @return string[]
     */
    public function allCommands(): array;
}
