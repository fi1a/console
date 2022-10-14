<?php

declare(strict_types=1);

namespace Fi1a\Console\IO\Style;

use InvalidArgumentException;

/**
 * ANSI класс цвета текста и фона
 */
class ANSIColor implements ColorInterface
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
        self::DEFAULT => 39, self::BLACK => 30, self::RED => 31, self::GREEN => 32, self::YELLOW => 33,
        self::BLUE => 34, self::MAGENTA => 35, self::CYAN => 36, self::GRAY => 37,
        self::DARK_GRAY => 90, self::LIGHT_RED => 91, self::LIGHT_GREEN => 92, self::LIGHT_YELLOW => 93,
        self::LIGHT_BLUE => 94, self::LIGHT_MAGENTA => 95, self::LIGHT_CYAN => 96, self::WHITE => 97,
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
        return (string) static::$colorCodes[$this->color];
    }

    /**
     * @inheritDoc
     */
    public function getBackgroundCode(): string
    {
        return (string) (static::$colorCodes[$this->color] + 10);
    }

    /**
     * @inheritDoc
     */
    public function getDefaultColorCode(): string
    {
        return (string) static::$colorCodes[self::DEFAULT];
    }

    /**
     * @inheritDoc
     */
    public function getDefaultBackgroundCode(): string
    {
        return (string) (static::$colorCodes[self::DEFAULT] + 10);
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
        if (!in_array($color, array_keys(static::$colorCodes))) {
            throw new InvalidArgumentException(sprintf('Неизвестный цвет "%s"', $color));
        }
        $this->color = $color;

        return true;
    }
}
