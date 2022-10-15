<?php

declare(strict_types=1);

namespace Fi1a\Console\IO\Style;

use InvalidArgumentException;

/**
 * ANSI класс цвета текста и фона
 */
class ANSIColor implements ColorInterface
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
        self::BLACK => 30, self::RED => 31, self::GREEN => 32, self::YELLOW => 33,
        self::BLUE => 34, self::MAGENTA => 35, self::CYAN => 36, self::GRAY => 37,
        self::LIGHT_RED => 91, self::LIGHT_GREEN => 92, self::LIGHT_YELLOW => 93,
        self::LIGHT_BLUE => 94, self::LIGHT_MAGENTA => 95, self::LIGHT_CYAN => 96, self::WHITE => 97,
        self::DARK_GRAY => 90,
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

        return (string) static::$colorCodes[$this->color];
    }

    /**
     * @inheritDoc
     */
    public function getBackgroundCode(): string
    {
        if ($this->isDefault()) {
            return '';
        }

        return (string) (static::$colorCodes[$this->color] + 10);
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
        if (!in_array($color, array_keys(static::$colorCodes)) && $color !== self::DEFAULT) {
            if (is_numeric($color) && (int) $color >= 0 && (int) $color <= 255) {
                [$r, $g, $b] = $this->getRgbFromExtended((int) $color);
                $color = $this->getAnsiForRGB($r, $g, $b);
            } elseif (substr($color, 0, 1) === '#' && (mb_strlen($color) === 7 || mb_strlen($color) === 4)) {
                [$r, $g, $b] = $this->getRGBFromHex($color);
                $color = $this->getAnsiForRGB($r, $g, $b);
            } else {
                throw new InvalidArgumentException(sprintf('Неизвестный цвет "%s"', $color));
            }
            $keys = array_keys(static::$colorCodes);
            $color = (string) $keys[$color];
        }
        $this->color = $color;

        return true;
    }
}
