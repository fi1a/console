<?php

declare(strict_types=1);

namespace Fi1a\Console\IO\Style;

/**
 *  Интерфейс цвета в консоле
 */
interface ColorInterface
{
    public const DEFAULT = 'default';
    public const BLACK   = 'black';
    public const RED     = 'red';
    public const GREEN   = 'green';
    public const YELLOW  = 'yellow';
    public const BLUE    = 'blue';
    public const MAGENTA = 'magenta';
    public const CYAN    = 'cyan';
    public const GRAY    = 'gray';
    public const DARK_GRAY     = 'dark_gray';
    public const LIGHT_RED     = 'light_red';
    public const LIGHT_GREEN   = 'light_green';
    public const LIGHT_YELLOW  = 'light_yellow';
    public const LIGHT_BLUE    = 'light_blue';
    public const LIGHT_MAGENTA = 'light_magenta';
    public const LIGHT_CYAN    = 'light_cyan';
    public const WHITE         = 'white';

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
