<?php

declare(strict_types=1);

namespace Fi1a\Console\IO;

use Fi1a\Console\IO\Style\StyleInterface;

/**
 * Форматирование вывода
 */
interface FormatterInterface
{
    /**
     * Добавляет стиль
     */
    public static function addStyle(string $name, StyleInterface $style): bool;

    /**
     * Проверяет наличие стиля
     */
    public static function hasStyle(string $name): bool;

    /**
     * Удаляет стиль
     */
    public static function deleteStyle(string $name): bool;

    /**
     * Возвращает стиль
     *
     * @param string|StyleInterface|null $style
     *
     * @return StyleInterface|false
     */
    public function getStyle(string $name);

    /**
     * Форматирование вывода
     *
     * @param string|StyleInterface|null $style
     */
    public function format(string $message, $style = null): string;
}
