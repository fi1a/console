<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\ProgressbarComponent;

/**
 * Реестр шаблонов
 */
interface ProgressbarTemplateRegistryInterface
{
    /**
     * Добавить шаблон
     */
    public static function add(string $name, string $template): bool;

    /**
     * Проверяет наличие шаблона
     */
    public static function has(string $name): bool;

    /**
     * Удаляет шаблон
     */
    public static function delete(string $name): bool;

    /**
     * Возвращает шаблон
     */
    public static function get(string $name): string;
}
