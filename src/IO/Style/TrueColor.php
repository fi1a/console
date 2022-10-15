<?php

declare(strict_types=1);

namespace Fi1a\Console\IO\Style;

/**
 * TrueColor класс цвета текста и фона
 */
class TrueColor implements ColorInterface
{
    use ColorTrait;

    /**
     * @var string
     */
    private $color = self::DEFAULT;

    public const MAROON = '#800000';
    public const DARK_RED = '#8B0000';
    public const FIRE_BRICK = '#B22222';
    public const SALMON = '#FA8072';
    public const TOMATO = '#FF6347';
    public const CORAL = '#FF7F50';
    public const ORANGE_RED = '#FF4500';
    public const CHOCOLATE = '#D2691E';
    public const SANDY_BROWN = '#F4A460';
    public const DARK_ORANGE = '#FF8C00';
    public const ORANGE = '#FFA500';
    public const DARK_GOLDENROD = '#B8860B';
    public const GOLDENROD = '#DAA520';
    public const GOLD = '#FFD700';
    public const OLIVE = '#808000';
    public const YELLOW_GREEN = '#9ACD32';
    public const GREEN_YELLOW = '#ADFF2F';
    public const CHARTREUSE = '#7FFF00';
    public const LAWN_GREEN = '#7CFC00';
    public const LIME = '#00FF00';
    public const LIME_GREEN = '#32CD32';
    public const SPRING_GREEN = '#00FF7F';
    public const MEDIUM_SPRING_GREEN = '#00FA9A';
    public const TURQUOISE = '#40E0D0';
    public const LIGHT_SEA_GREEN = '#20B2AA';
    public const MEDIUM_TURQUOISE = '#48D1CC';
    public const TEAL = '#008080';
    public const DARK_CYAN = '#008B8B';
    public const AQUA = '#00FFFF';
    public const DARK_TURQUOISE = '#00CED1';
    public const DEEP_SKY_BLUE = '#00BFFF';
    public const DODGER_BLUE = '#1E90FF';
    public const ROYAL_BLUE = '#4169E1';
    public const NAVY = '#000080';
    public const DARK_BLUE = '#00008B';
    public const MEDIUM_BLUE = '#0000CD';
    public const BLUE_VIOLET = '#8A2BE2';
    public const DARK_ORCHID = '#9932CC';
    public const DARK_VIOLET = '#9400D3';
    public const PURPLE = '#800080';
    public const DARK_MAGENTA = '#8B008B';
    public const FUCHSIA = '#FF00FF';
    public const MEDIUM_VIOLET_RED = '#C71585';
    public const DEEP_PINK = '#FF1493';
    public const HOT_PINK = '#FF69B4';
    public const CRIMSON = '#DC143C';
    public const BROWN = '#A52A2A';
    public const INDIAN_RED = '#CD5C5C';
    public const ROSY_BROWN = '#BC8F8F';
    public const LIGHT_CORAL = '#F08080';
    public const SNOW = '#FFFAFA';
    public const MISTY_ROSE = '#FFE4E1';
    public const DARK_SALMON = '#E9967A';
    public const LIGHT_SALMON = '#FFA07A';
    public const SIENNA = '#A0522D';
    public const SEA_SHELL = '#FFF5EE';
    public const SADDLE_BROWN = '#8B4513';
    public const PEACHPUFF = '#FFDAB9';
    public const PERU = '#CD853F';
    public const LINEN = '#FAF0E6';
    public const BISQUE = '#FFE4C4';
    public const BURLYWOOD = '#DEB887';
    public const TAN = '#D2B48C';
    public const ANTIQUE_WHITE = '#FAEBD7';
    public const NAVAJO_WHITE = '#FFDEAD';
    public const BLANCHED_ALMOND = '#FFEBCD';
    public const PAPAYA_WHIP = '#FFEFD5';
    public const MOCCASIN = '#FFE4B5';
    public const WHEAT = '#F5DEB3';
    public const OLDLACE = '#FDF5E6';
    public const FLORAL_WHITE = '#FFFAF0';
    public const CORNSILK = '#FFF8DC';
    public const KHAKI = '#F0E68C';
    public const LEMON_CHIFFON = '#FFFACD';
    public const PALE_GOLDENROD = '#EEE8AA';
    public const DARK_KHAKI = '#BDB76B';
    public const BEIGE = '#F5F5DC';
    public const LIGHT_GOLDENROD_YELLOW = '#FAFAD2';
    public const IVORY = '#FFFFF0';
    public const OLIVE_DRAB = '#6B8E23';
    public const DARK_OLIVE_GREEN = '#556B2F';
    public const DARK_SEA_GREEN = '#8FBC8F';
    public const DARK_GREEN = '#006400';
    public const FOREST_GREEN = '#228B22';
    public const PALE_GREEN = '#98FB98';
    public const HONEYDEW = '#F0FFF0';
    public const SEA_GREEN = '#2E8B57';
    public const MEDIUM_SEA_GREEN = '#3CB371';
    public const MINTCREAM = '#F5FFFA';
    public const MEDIUM_AQUAMARINE = '#66CDAA';
    public const AQUAMARINE = '#7FFFD4';
    public const DARK_SLATE_GRAY = '#2F4F4F';
    public const PALE_TURQUOISE = '#AFEEEE';
    public const AZURE = '#F0FFFF';
    public const CADET_BLUE = '#5F9EA0';
    public const POWDER_BLUE = '#B0E0E6';
    public const SKY_BLUE = '#87CEEB';
    public const LIGHTSKY_BLUE = '#87CEFA';
    public const STEEL_BLUE = '#4682B4';
    public const ALICE_BLUE = '#F0F8FF';
    public const SLATE_GRAY = '#708090';
    public const LIGHT_SLATE_GRAY = '#778899';
    public const LIGHTSTEEL_BLUE = '#B0C4DE';
    public const CORNFLOWER_BLUE = '#6495ED';
    public const LAVENDER = '#E6E6FA';
    public const GHOST_WHITE = '#F8F8FF';
    public const MIDNIGHT_BLUE = '#191970';
    public const SLATE_BLUE = '#6A5ACD';
    public const DARK_SLATE_BLUE = '#483D8B';
    public const MEDIUM_SLATE_BLUE = '#7B68EE';
    public const MEDIUM_PURPLE = '#9370DB';
    public const INDIGO = '#4B0082';
    public const MEDIUM_ORCHID = '#BA55D3';
    public const PLUM = '#DDA0DD';
    public const VIOLET = '#EE82EE';
    public const THISTLE = '#D8BFD8';
    public const ORCHID = '#DA70D6';
    public const LAVENDER_BLUSH = '#FFF0F5';
    public const PALE_VIOLET_RED = '#DB7093';
    public const PINK = '#FFC0CB';
    public const LIGHT_PINK = '#FFB6C1';
    public const DIM_GRAY = '#696969';
    public const SILVER = '#C0C0C0';
    public const LIGHT_GREY = '#D3D3D3';
    public const GAINSBORO = '#DCDCDC';
    public const WHITE_SMOKE = '#F5F5F5';
    public const REBECCA_PURPLE = '#663399';

    /**
     * @var string[]
     */
    private static $colorCodes = [
        self::BLACK => '#000000', self::RED => '#b83019', self::GREEN => '#51bf37', self::YELLOW => '#c6c43d',
        self::BLUE => '#0c24bf', self::MAGENTA => '#b93ec1', self::CYAN => '#53c2c5', self::WHITE => '#ffffff',
        self::GRAY => '#676767', self::LIGHT_RED => '#ef766d', self::LIGHT_GREEN => '#8cf67a',
        self::LIGHT_YELLOW => '#fefb7e', self::LIGHT_BLUE => '#6a71f6', self::LIGHT_MAGENTA => '#f07ef8',
        self::LIGHT_CYAN => '#8ef9fd', self::DARK_GRAY => '#c7c7c7',
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

        [$r, $g, $b] = $this->getRgb($this->color);

        return '38;2;' . $r . ';' . $g . ';' . $b;
    }

    /**
     * @inheritDoc
     */
    public function getBackgroundCode(): string
    {
        if ($this->isDefault()) {
            return '';
        }

        [$r, $g, $b] = $this->getRgb($this->color);

        return '48;2;' . $r . ';' . $g . ';' . $b;
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
        $this->color = $color;

        return true;
    }

    /**
     * Возвращает rgb
     *
     * @return int[]
     */
    protected function getRgb(string $color): array
    {
        $hex = $color;
        if (in_array($color, array_keys(static::$colorCodes))) {
            $hex = static::$colorCodes[$color];
        }

        return $this->getRGBFromHex($hex);
    }
}
