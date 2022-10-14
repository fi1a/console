<?php

declare(strict_types=1);

namespace Fi1a\Console\IO\Style;

use InvalidArgumentException;

/**
 * Расширенный класс цвета текста и фона
 */
class ExtendedColor implements ColorInterface
{
    /**
     * @var string
     */
    private $color = self::DEFAULT;

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
     * @var int[]
     */
    private static $colorCodes = [
        self::DEFAULT => 39, self::BLACK => 0, self::RED => 1, self::GREEN => 2, self::YELLOW => 3,
        self::BLUE => 4, self::MAGENTA => 5, self::CYAN => 6, self::WHITE => 15,
        self::GRAY => 7, self::LIGHT_RED => 9, self::LIGHT_GREEN => 10, self::LIGHT_YELLOW => 11,
        self::LIGHT_BLUE => 14, self::LIGHT_MAGENTA => 13, self::LIGHT_CYAN => 14,
        self::DARK_GRAY => 244,
    ];

    /**
     * @inheritDoc
     */
    public function __construct(?string $color = null)
    {
        if (is_null($color)) {
            $color = self::DEFAULT;
        }
        $this->setColor($color);
    }

    /**
     * @inheritDoc
     */
    public function getColorCode(): string
    {
        if (is_numeric($this->color)) {
            return '38;5;' . $this->color;
        }

        return '38;5;' . static::$colorCodes[$this->color];
    }

    /**
     * @inheritDoc
     */
    public function getBackgroundCode(): string
    {
        if (is_numeric($this->color)) {
            return '48;5;' . $this->color;
        }

        return '48;5;' . static::$colorCodes[$this->color];
    }

    /**
     * @inheritDoc
     */
    public function isDefault(): bool
    {
        return $this->color === static::DEFAULT;
    }

    /**
     * @inheritDoc
     */
    public function setColor(string $color): bool
    {
        if (is_numeric($color) && ((int) $color < 0 || (int) $color > 255)) {
            throw new InvalidArgumentException(sprintf('Неизвестный цвет "%s"', $color));
        } elseif (!is_numeric($color) && !in_array($color, array_keys(static::$colorCodes))) {
            throw new InvalidArgumentException(sprintf('Неизвестный цвет "%s"', $color));
        }
        $this->color = $color;

        return true;
    }
}
