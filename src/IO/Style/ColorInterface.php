<?php

declare(strict_types=1);

namespace Fi1a\Console\IO\Style;

/**
 *  Интерфейс цвета в консоле
 */
interface ColorInterface
{
    /**
     * Конструктор
     */
    public function __construct(?string $color = null);

    /**
     * Возвращает код цвета
     */
    public function getColorCode(): string;

    /**
     * Возвращает код цвета фона
     */
    public function getBackgroundCode(): string;

    /**
     * Цвет по умолчанию или нет
     */
    public function isDefault(): bool;

    /**
     * Установить цвет
     */
    public function setColor(string $color): bool;
}
