<?php

declare(strict_types=1);

namespace Fi1a\Console\IO;

/**
 * Интерактивный ввод
 */
interface InteractiveInputInterface
{
    /**
     * Конструктор
     */
    public function __construct(ConsoleOutputInterface $output, InputInterface $input);

    /**
     * Устанавливает вывод
     */
    public function setOutput(ConsoleOutputInterface $output): bool;

    /**
     * Возвращает вывод
     */
    public function getOutput(): ConsoleOutputInterface;

    /**
     * Устанавливает ввод
     */
    public function setInput(InputInterface $input): bool;

    /**
     * Возвращает ввод
     */
    public function getInput(): InputInterface;

    /**
     * Добавить значение
     */
    public function addValue(string $name): InteractiveValue;

    /**
     * Определяет есть ли значение
     */
    public function hasValue(string $name): bool;

    /**
     * Возвращает значение
     *
     * @return InteractiveValue|false
     */
    public function getValue(string $name);

    /**
     * Удаление значения
     */
    public function deleteValue(string $name): bool;

    /**
     * Список значений
     *
     * @return InteractiveValue[]
     */
    public function allValues(): array;

    /**
     * Чтение
     */
    public function read(): bool;
}
