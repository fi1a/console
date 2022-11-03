<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\ListComponent;

/**
 * Реестр оформления списка
 */
interface ListTypeRegistryInterface
{
    /**
     * Добавить оформление списка
     */
    public static function add(string $name, ListTypeInterface $listType): bool;

    /**
     * Проверяет наличие оформления списка в коллекции
     */
    public static function has(string $name): bool;

    /**
     * Возвращает оформление списка
     */
    public static function get(string $name): ListTypeInterface;

    /**
     * Удаляет оформление списка
     */
    public static function delete(string $name): bool;
}
