<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\TableComponent;

/**
 * Реестр оформления границ
 */
interface BorderRegistryInterface
{
    /**
     * Добавить оформление границ в коллекцию
     */
    public static function add(string $name, BorderInterface $border): bool;

    /**
     * Проверяет наличие оформления границ в коллекции
     */
    public static function has(string $name): bool;

    /**
     * Возвращает оформление границ
     */
    public static function get(string $name): BorderInterface;

    /**
     * Удаляет оформление границ
     */
    public static function delete(string $name): bool;
}
