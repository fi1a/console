<?php

declare(strict_types=1);

namespace Fi1a\Console\IO\Style;

use InvalidArgumentException;

/**
 * TrueColor класс цвета текста и фона
 */
class TrueColor implements ColorInterface
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

    public const MAROON = 'maroon';
    public const DARK_RED = 'dark_red';
    public const FIRE_BRICK = 'fire_brick';
    public const SALMON = 'salmon';
    public const TOMATO = 'tomato';
    public const CORAL = 'coral';
    public const ORANGE_RED = 'orange_red';
    public const CHOCOLATE = 'chocolate';
    public const SANDY_BROWN = 'sandy_brown';
    public const DARK_ORANGE = 'dark_orange';
    public const ORANGE = 'orange';
    public const DARK_GOLDENROD = 'dark_goldenrod';
    public const GOLDENROD = 'goldenrod';
    public const GOLD = 'gold';
    public const OLIVE = 'olive';
    public const YELLOW_GREEN = 'yellow_green';
    public const GREEN_YELLOW = 'green_yellow';
    public const CHARTREUSE = 'chartreuse';
    public const LAWN_GREEN = 'lawn_green';
    public const LIME = 'lime';
    public const LIME_GREEN = 'lime_green';
    public const SPRING_GREEN = 'spring_green';
    public const MEDIUM_SPRING_GREEN = 'medium_spring_green';
    public const TURQUOISE = 'turquoise';
    public const LIGHT_SEA_GREEN = 'light_sea_green';
    public const MEDIUM_TURQUOISE = 'medium_turquoise';
    public const TEAL = 'teal';
    public const DARK_CYAN = 'dark_cyan';
    public const AQUA = 'aqua';
    public const DARK_TURQUOISE = 'dark_turquoise';
    public const DEEP_SKY_BLUE = 'deep_sky_blue';
    public const DODGER_BLUE = 'dodger_blue';
    public const ROYAL_BLUE = 'royal_blue';
    public const NAVY = 'navy';
    public const DARK_BLUE = 'dark_blue';
    public const MEDIUM_BLUE = 'medium_blue';
    public const BLUE_VIOLET = 'blue_violet';
    public const DARK_ORCHID = 'dark_orchid';
    public const DARK_VIOLET = 'dark_violet';
    public const PURPLE = 'purple';
    public const DARK_MAGENTA = 'dark_magenta';
    public const FUCHSIA = 'fuchsia';
    public const MEDIUM_VIOLET_RED = 'medium_violet_red';
    public const DEEP_PINK = 'deep_pink';
    public const HOT_PINK = 'hot_pink';
    public const CRIMSON = 'crimson';
    public const BROWN = 'brown';
    public const INDIAN_RED = 'indian_red';
    public const ROSY_BROWN = 'rosy_brown';
    public const LIGHT_CORAL = 'light_coral';
    public const SNOW = 'snow';
    public const MISTY_ROSE = 'misty_rose';
    public const DARK_SALMON = 'dark_salmon';
    public const LIGHT_SALMON = 'light_salmon';
    public const SIENNA = 'sienna';
    public const SEA_SHELL = 'sea_shell';
    public const SADDLE_BROWN = 'saddle_brown';
    public const PEACHPUFF = 'peachpuff';
    public const PERU = 'peru';
    public const LINEN = 'linen';
    public const BISQUE = 'bisque';
    public const BURLYWOOD = 'burlywood';
    public const TAN = 'tan';
    public const ANTIQUE_WHITE = 'antique_white';
    public const NAVAJO_WHITE = 'navajo_white';
    public const BLANCHED_ALMOND = 'blanched_almond';
    public const PAPAYA_WHIP = 'papaya_whip';
    public const MOCCASIN = 'moccasin';
    public const WHEAT = 'wheat';
    public const OLDLACE = 'oldlace';
    public const FLORAL_WHITE = 'floral_white';
    public const CORNSILK = 'cornsilk';
    public const KHAKI = 'khaki';
    public const LEMON_CHIFFON = 'lemon_chiffon';
    public const PALE_GOLDENROD = 'pale_goldenrod';
    public const DARK_KHAKI = 'dark_khaki';
    public const BEIGE = 'beige';
    public const LIGHT_GOLDENROD_YELLOW = 'light_goldenrod_yellow';
    public const IVORY = 'ivory';
    public const OLIVE_DRAB = 'olive_drab';
    public const DARK_OLIVE_GREEN = 'dark_olive_green';
    public const DARK_SEA_GREEN = 'dark_sea_green';
    public const DARK_GREEN = 'dark_green';
    public const FOREST_GREEN = 'forest_green';
    public const PALE_GREEN = 'pale_green';
    public const HONEYDEW = 'honeydew';
    public const SEA_GREEN = 'sea_green';
    public const MEDIUM_SEA_GREEN = 'medium_sea_green';
    public const MINTCREAM = 'mintcream';
    public const MEDIUM_AQUAMARINE = 'medium_aquamarine';
    public const AQUAMARINE = 'aquamarine';
    public const DARK_SLATE_GRAY = 'dark_slate_gray';
    public const PALE_TURQUOISE = 'pale_turquoise';
    public const AZURE = 'azure';
    public const CADET_BLUE = 'cadet_blue';
    public const POWDER_BLUE = 'powder_blue';
    public const SKY_BLUE = 'sky_blue';
    public const LIGHTSKY_BLUE = 'lightsky_blue';
    public const STEEL_BLUE = 'steel_blue';
    public const ALICE_BLUE = 'alice_blue';
    public const SLATE_GRAY = 'slate_gray';
    public const LIGHT_SLATE_GRAY = 'light_slate_gray';
    public const LIGHTSTEEL_BLUE = 'lightsteel_blue';
    public const CORNFLOWER_BLUE = 'cornflower_blue';
    public const LAVENDER = 'lavender';
    public const GHOST_WHITE = 'ghost_white';
    public const MIDNIGHT_BLUE = 'midnight_blue';
    public const SLATE_BLUE = 'slate_blue';
    public const DARK_SLATE_BLUE = 'dark_slate_blue';
    public const MEDIUM_SLATE_BLUE = 'medium_slate_blue';
    public const MEDIUM_PURPLE = 'medium_purple';
    public const INDIGO = 'indigo';
    public const MEDIUM_ORCHID = 'medium_orchid';
    public const PLUM = 'plum';
    public const VIOLET = 'violet';
    public const THISTLE = 'thistle';
    public const ORCHID = 'orchid';
    public const LAVENDER_BLUSH = 'lavender_blush';
    public const PALE_VIOLET_RED = 'pale_violet_red';
    public const PINK = 'pink';
    public const LIGHT_PINK = 'light_pink';
    public const DIM_GRAY = 'dim_gray';
    public const SILVER = 'silver';
    public const LIGHT_GREY = 'light_grey';
    public const GAINSBORO = 'gainsboro';
    public const WHITE_SMOKE = 'white_smoke';
    public const REBECCA_PURPLE = 'rebecca_purple';

    /**
     * @var string[]
     */
    private static $colorCodes = [
        self::BLACK => '#000000', self::RED => '#b83019', self::GREEN => '#51bf37', self::YELLOW => '#c6c43d',
        self::BLUE => '#0c24bf', self::MAGENTA => '#b93ec1', self::CYAN => '#53c2c5', self::WHITE => '#ffffff',
        self::GRAY => '#676767', self::LIGHT_RED => '#ef766d', self::LIGHT_GREEN => '#8cf67a',
        self::LIGHT_YELLOW => '#fefb7e', self::LIGHT_BLUE => '#6a71f6', self::LIGHT_MAGENTA => '#f07ef8',
        self::LIGHT_CYAN => '#8ef9fd', self::DARK_GRAY => '#c7c7c7', self::MAROON => '#800000',
        self::DARK_RED => '#8B0000', self::FIRE_BRICK => '#B22222', self::SALMON => '#FA8072',
        self::TOMATO => '#FF6347', self::CORAL => '#FF7F50', self::ORANGE_RED => '#FF4500',
        self::CHOCOLATE => '#D2691E', self::SANDY_BROWN => '#F4A460', self::DARK_ORANGE => '#FF8C00',
        self::ORANGE => '#FFA500', self::DARK_GOLDENROD => '#B8860B', self::GOLDENROD => '#DAA520',
        self::GOLD => '#FFD700', self::OLIVE => '#808000', self::YELLOW_GREEN => '#9ACD32',
        self::GREEN_YELLOW => '#ADFF2F', self::CHARTREUSE => '#7FFF00', self::LAWN_GREEN => '#7CFC00',
        self::LIME => '#00FF00', self::LIME_GREEN => '#32CD32', self::SPRING_GREEN => '#00FF7F',
        self::MEDIUM_SPRING_GREEN => '#00FA9A', self::TURQUOISE => '#40E0D0', self::LIGHT_SEA_GREEN => '#20B2AA',
        self::MEDIUM_TURQUOISE => '#48D1CC', self::TEAL => '#008080', self::DARK_CYAN => '#008B8B',
        self::AQUA => '#00FFFF', self::DARK_TURQUOISE => '#00CED1', self::DEEP_SKY_BLUE => '#00BFFF',
        self::DODGER_BLUE => '#1E90FF', self::ROYAL_BLUE => '#4169E1', self::NAVY => '#000080',
        self::DARK_BLUE => '#00008B', self::MEDIUM_BLUE => '#0000CD', self::BLUE_VIOLET => '#8A2BE2',
        self::DARK_ORCHID => '#9932CC', self::DARK_VIOLET => '#9400D3', self::PURPLE => '#800080',
        self::DARK_MAGENTA => '#8B008B', self::FUCHSIA => '#FF00FF', self::MEDIUM_VIOLET_RED => '#C71585',
        self::DEEP_PINK => '#FF1493', self::HOT_PINK => '#FF69B4', self::CRIMSON => '#DC143C',
        self::BROWN => '#A52A2A', self::INDIAN_RED => '#CD5C5C', self::ROSY_BROWN => '#BC8F8F',
        self::LIGHT_CORAL => '#F08080', self::SNOW => '#FFFAFA', self::MISTY_ROSE => '#FFE4E1',
        self::DARK_SALMON => '#E9967A', self::LIGHT_SALMON => '#FFA07A', self::SIENNA => '#A0522D',
        self::SEA_SHELL => '#FFF5EE', self::SADDLE_BROWN => '#8B4513', self::PEACHPUFF => '#FFDAB9',
        self::PERU => '#CD853F', self::LINEN => '#FAF0E6', self::BISQUE => '#FFE4C4',
        self::BURLYWOOD => '#DEB887', self::TAN => '#D2B48C', self::ANTIQUE_WHITE => '#FAEBD7',
        self::NAVAJO_WHITE => '#FFDEAD', self::BLANCHED_ALMOND => '#FFEBCD', self::PAPAYA_WHIP => '#FFEFD5',
        self::MOCCASIN => '#FFE4B5', self::WHEAT => '#F5DEB3', self::OLDLACE => '#FDF5E6',
        self::FLORAL_WHITE => '#FFFAF0', self::CORNSILK => '#FFF8DC', self::KHAKI => '#F0E68C',
        self::LEMON_CHIFFON => '#FFFACD', self::PALE_GOLDENROD => '#EEE8AA', self::DARK_KHAKI => '#BDB76B',
        self::BEIGE => '#F5F5DC', self::LIGHT_GOLDENROD_YELLOW => '#FAFAD2', self::IVORY => '#FFFFF0',
        self::OLIVE_DRAB => '#6B8E23', self::DARK_OLIVE_GREEN => '#556B2F', self::DARK_SEA_GREEN => '#8FBC8F',
        self::DARK_GREEN => '#006400', self::FOREST_GREEN => '#228B22', self::PALE_GREEN => '#98FB98',
        self::HONEYDEW => '#F0FFF0', self::SEA_GREEN => '#2E8B57', self::MEDIUM_SEA_GREEN => '#3CB371',
        self::MINTCREAM => '#F5FFFA', self::MEDIUM_AQUAMARINE => '#66CDAA', self::AQUAMARINE => '#7FFFD4',
        self::DARK_SLATE_GRAY => '#2F4F4F', self::PALE_TURQUOISE => '#AFEEEE', self::AZURE => '#F0FFFF',
        self::CADET_BLUE => '#5F9EA0', self::POWDER_BLUE => '#B0E0E6', self::SKY_BLUE => '#87CEEB',
        self::LIGHTSKY_BLUE => '#87CEFA', self::STEEL_BLUE => '#4682B4', self::ALICE_BLUE => '#F0F8FF',
        self::SLATE_GRAY => '#708090', self::LIGHT_SLATE_GRAY => '#778899', self::LIGHTSTEEL_BLUE => '#B0C4DE',
        self::CORNFLOWER_BLUE => '#6495ED', self::LAVENDER => '#E6E6FA', self::GHOST_WHITE => '#F8F8FF',
        self::MIDNIGHT_BLUE => '#191970', self::SLATE_BLUE => '#6A5ACD', self::DARK_SLATE_BLUE => '#483D8B',
        self::MEDIUM_SLATE_BLUE => '#7B68EE', self::MEDIUM_PURPLE => '#9370DB', self::INDIGO => '#4B0082',
        self::MEDIUM_ORCHID => '#BA55D3', self::PLUM => '#DDA0DD', self::VIOLET => '#EE82EE',
        self::THISTLE => '#D8BFD8', self::ORCHID => '#DA70D6', self::LAVENDER_BLUSH => '#FFF0F5',
        self::PALE_VIOLET_RED => '#DB7093', self::PINK => '#FFC0CB', self::LIGHT_PINK => '#FFB6C1',
        self::DIM_GRAY => '#696969', self::SILVER => '#C0C0C0', self::LIGHT_GREY => '#D3D3D3',
        self::GAINSBORO => '#DCDCDC', self::WHITE_SMOKE => '#F5F5F5', self::REBECCA_PURPLE => '#663399',
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

        return [$r, $g, $b];
    }
}
