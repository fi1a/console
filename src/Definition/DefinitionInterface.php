<?php

declare(strict_types=1);

namespace Fi1a\Console\Definition;

use Fi1a\Console\IO\InputArgumentsInterface;

/**
 * Определение входных опций и аргументов
 */
interface DefinitionInterface
{
    /**
     * Добавить опцию
     */
    public function addOption(string $name, ?string $shortName = null): OptionInterface;

    /**
     * Проверяет наличие опции
     */
    public function hasOption(string $name): bool;

    /**
     * Возвращает опцию
     *
     * @return OptionInterface|false
     */
    public function getOption(string $name);

    /**
     * Удаляет опцию
     */
    public function deleteOption(string $name): bool;

    /**
     * Возвращает все опции
     *
     * @return OptionInterface[]
     */
    public function allOptions(): array;

    /**
     * Проверяет наличие сокращенной нотации опции
     */
    public function hasShortOption(string $shortName): bool;

    /**
     * Возвращает сокращенную нотацию опции
     *
     * @return OptionInterface|false
     */
    public function getShortOption(string $shortName);

    /**
     * Удаляет сокращенную нотацию опции
     */
    public function deleteShortOption(string $shortName): bool;

    /**
     * Возвращает все сокращенные нотации опции
     *
     * @return OptionInterface[]
     */
    public function allShortOptions(): array;

    /**
     * Парсинг значений
     */
    public function parseValues(InputArgumentsInterface $input): void;
}
