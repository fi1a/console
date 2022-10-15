<?php

declare(strict_types=1);

namespace Fi1a\Console\IO\Style;

use InvalidArgumentException;

/**
 * Вспомогательные методы
 */
trait ColorTrait
{
    /**
     * Возвращает RGB для Extended Colors
     *
     * @return int[]
     */
    protected function getRgbFromExtended(int $color): array
    {
        $r = ($color - 16) / 36 * 51;
        $g = (($color - 16) % 36) / 6 * 51;
        $b = (($color - 16) % 6) * 51;

        return [(int) $r, (int) $g, $b];
    }

    /**
     * Возвращает ANSI для RGB
     */
    protected function getAnsiForRGB(int $r, int $g, int $b): int
    {
        return (int) ((round($b / 255) << 2) | (round($g / 255) << 1) | round($r / 255));
    }

    /**
     * Возвращает RGB по HEX
     *
     * @return int[]
     */
    protected function getRGBFromHex(string $hex): array
    {
        $hex = str_replace('#', '', $hex);

        if (strlen($hex) === 6) {
            $r = hexdec($hex[0] . $hex[1]);
            $g = hexdec($hex[2] . $hex[3]);
            $b = hexdec($hex[4] . $hex[5]);
        } elseif (strlen($hex) === 3) {
            $r = hexdec($hex[0] . $hex[0]);
            $g = hexdec($hex[1] . $hex[1]);
            $b = hexdec($hex[2] . $hex[2]);
        } else {
            throw new InvalidArgumentException('Ошибка значения цвета');
        }

        return [(int) $r, (int) $g, (int) $b];
    }
}
