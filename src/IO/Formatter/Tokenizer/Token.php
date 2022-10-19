<?php

declare(strict_types=1);

namespace Fi1a\Console\IO\Formatter\Tokenizer;

use Fi1a\Tokenizer\AToken;

/**
 * Токен
 */
class Token extends AToken
{
    /**
     * Неизвестный токен
     */
    public const T_UNKNOWN_TOKEN_TYPE = 1;

    /**
     * 'text'
     */
    public const T_TEXT = 10;

    /**
     *  -
     *  <color=red></>
     *  -
     */
    public const T_OPEN_TAG_STYLE = 20;

    /**
     *            -
     *  <color=red></>
     *            -
     */
    public const T_CLOSE_TAG_STYLE = 30;

    /**
     *             ---
     *  <color=red></>
     *             ---
     */
    public const T_END_TAG_STYLE = 40;

    /**
     *   -----
     *  <color=red></>
     *   -----
     */
    public const T_COLOR = 50;

    /**
     *   --
     *  <bg=red></>
     *   --
     */
    public const T_BG = 60;

    /**
     *   ------
     *  <option=underscore, bold></>
     *   ------
     */
    public const T_OPTION = 70;

    /**
     *                     -
     *  <option=underscore, bold></>
     *                     -
     */
    public const T_WHITESPACE = 80;

    /**
     *                    -
     *  <option=underscore, bold></>
     *                    -
     */
    public const T_COMMA_SEPARATOR = 90;

    /**
     *         -
     *  <option=underscore, bold></>
     *         -
     */
    public const T_ASSIGMENT = 100;

    /**
     *          ----------  ----
     *  <option=underscore, bold></>
     *          ----------  ----
     */
    public const T_VALUE = 110;

    /**
     *                          -
     *  <option=underscore, bold;color=white></>
     *                          -
     */
    public const T_SEMICOLON = 120;

    /**
     *                          -
     *  <option=underscore, bold;color=white></>
     *                          -
     */
    public const T_STYLE_NAME = 130;

    /**
     *          -          -  -    -
     *  <option="underscore", "bold";color=white></>
     *          -          -  -    -
     */
    public const T_QUOTE = 140;

    /**
     * @var int[]
     */
    private static $types = [
        self::T_UNKNOWN_TOKEN_TYPE, self::T_TEXT, self::T_OPEN_TAG_STYLE, self::T_CLOSE_TAG_STYLE,
        self::T_END_TAG_STYLE, self::T_COLOR, self::T_BG, self::T_OPTION, self::T_WHITESPACE,
        self::T_COMMA_SEPARATOR, self::T_ASSIGMENT, self::T_VALUE, self::T_SEMICOLON, self::T_STYLE_NAME,
        self::T_QUOTE,
    ];

    /**
     * @inheritDoc
     */
    protected function getTypes(): array
    {
        return static::$types;
    }
}
