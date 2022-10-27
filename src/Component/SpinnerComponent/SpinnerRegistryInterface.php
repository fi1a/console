<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\SpinnerComponent;

/**
 * Реестр спиннеров
 */
interface SpinnerRegistryInterface
{
    /**
     * Добавить спиннер в коллекцию
     */
    public static function add(string $name, SpinnerInterface $spinner): bool;

    /**
     * Проверяет наличие спиннера в коллекции
     */
    public static function has(string $name): bool;

    /**
     * Возвращает спиннер
     */
    public static function get(string $name): SpinnerInterface;

    /**
     * Удаляет спиннер
     */
    public static function delete(string $name): bool;
}
