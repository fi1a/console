<?php

declare(strict_types=1);

namespace Fi1a\Console\IO\Style;

use InvalidArgumentException;

/**
 * Расширенный класс цвета текста и фона
 */
class ExtendedColor implements ColorInterface
{
    use ColorTrait;

    /**
     * @var string
     */
    private $color = self::DEFAULT;

    /**
     * @var int[]
     */
    private static $colorCodes = [
        self::BLACK => 0, self::RED => 1, self::GREEN => 2, self::YELLOW => 3,
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
        if ($this->isDefault()) {
            return '';
        }
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
        if ($this->isDefault()) {
            return '';
        }
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
        } elseif (
            !is_numeric($color)
            && !in_array($color, array_keys(static::$colorCodes))
            && $color !== self::DEFAULT
        ) {
            if (substr($color, 0, 1) === '#' && (mb_strlen($color) === 7 || mb_strlen($color) === 4)) {
                [$r, $g, $b] = $this->getRGBFromHex($color);
                $color = $this->getAnsiForRGB($r, $g, $b);
                $keys = array_keys(static::$colorCodes);
                $color = (string) $keys[$color];
            } else {
                throw new InvalidArgumentException(sprintf('Неизвестный цвет "%s"', $color));
            }
        }
        $this->color = $color;

        return true;
    }
}
