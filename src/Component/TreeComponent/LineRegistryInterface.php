<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\TreeComponent;

/**
 * Реестр оформления линии дерева
 */
interface LineRegistryInterface
{
    /**
     * Добавить оформление линии
     */
    public static function add(string $name, LineInterface $listType): bool;

    /**
     * Проверяет наличие оформления линии в коллекции
     */
    public static function has(string $name): bool;

    /**
     * Возвращает оформление линии
     */
    public static function get(string $name): LineInterface;

    /**
     * Удаляет оформление линии
     */
    public static function delete(string $name): bool;
}
