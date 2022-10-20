<?php

declare(strict_types=1);

namespace Fi1a\Console\IO\Formatter\Tokenizer;

use Fi1a\Tokenizer\AParseFunction;
use Fi1a\Tokenizer\IToken;

/**
 * Лексический анализатор
 */
class Tokenizer extends AParseFunction
{
    /**
     * @var string
     */
    private $whiteSpaceReturn = '';

    /**
     * @var string
     */
    private $quoteReturn = '';

    /**
     * @var int[]
     */
    private static $keywords = [
        'color' => Token::T_COLOR,
        'bg' => Token::T_BG,
        'option' => Token::T_OPTION,
    ];

    /**
     * @inheritDoc
     */
    public function __construct(string $source, ?string $encoding = null)
    {
        $this->setParseFunction('parse');
        parent::__construct($source, $encoding);
    }

    /**
     * Базовая функция парсинга
     *
     * @param IToken[] $tokens
     */
    protected function parse(
        bool &$finish,
        string &$source,
        int &$current,
        string &$image,
        ?int &$type,
        array &$tokens,
        bool &$quote,
        bool &$single
    ): void {
        do {
            $current++;
            if (!$source || $current >= mb_strlen($source)) {
                $finish = true;

                return;
            }

            $symbol = mb_substr($source, $current, 1);
            $prevSymbol = mb_substr($source, $current - 1, 1);
            $nextSymbol = mb_substr($source, $current + 1, 1);

            if ($symbol === '<' && $prevSymbol !== '\\' && $nextSymbol === '/') {
                $this->setParseFunction('parseEndTagStyle');

                return;
            }
            if ($symbol === '<' && $prevSymbol !== '\\') {
                $this->setParseFunction('parseOpenTagStyle');

                return;
            }

            $type = Token::T_TEXT;
            $image .= $symbol;
        } while (true);
    }

    /**
     * Парсинг закрытия тега
     *
     *           -
     * <color=red></>
     *           -
     *
     * @param IToken[]    $tokens
     */
    protected function parseCloseTagStyle(
        bool &$finish,
        string &$source,
        int &$current,
        string &$image,
        ?int &$type,
        array &$tokens,
        bool &$quote,
        bool &$single
    ): void {
        $symbol = mb_substr($source, $current, 1);
        if ($symbol === '>') {
            $image = $symbol;
            $type = Token::T_CLOSE_TAG_STYLE;
        }
        $this->setParseFunction('parse');
    }

    /**
     * Парсинг открытия тега
     *
     * -
     * <color=red></>
     * -
     *
     * @param IToken[]    $tokens
     */
    protected function parseOpenTagStyle(
        bool &$finish,
        string &$source,
        int &$current,
        string &$image,
        ?int &$type,
        array &$tokens,
        bool &$quote,
        bool &$single
    ): void {
        $symbol = mb_substr($source, $current, 1);
        $image = $symbol;
        $type = Token::T_OPEN_TAG_STYLE;
        $this->setParseFunction('parseStyle');
        $current++;
    }

    /**
     * Парсинг точки с запятой в стилях
     *
     *           -
     * <color=red;bg=white></>
     *           -
     *
     * @param IToken[] $tokens
     */
    protected function parseSemicolon(
        bool &$finish,
        string &$source,
        int &$current,
        string &$image,
        ?int &$type,
        array &$tokens,
        bool &$quote,
        bool &$single
    ): void {
        $symbol = mb_substr($source, $current, 1);
        $image = $symbol;
        $type = Token::T_SEMICOLON;
        $this->setParseFunction('parseStyle');
        $current++;
    }

    /**
     * Парсинг присвоения
     *
     *       -
     * <color=red></>
     *       -
     *
     * @param IToken[] $tokens
     */
    protected function parseAssigment(
        bool &$finish,
        string &$source,
        int &$current,
        string &$image,
        ?int &$type,
        array &$tokens,
        bool &$quote,
        bool &$single
    ): void {
        $symbol = mb_substr($source, $current, 1);
        $image = $symbol;
        $type = Token::T_ASSIGMENT;
        $this->setParseFunction('parseValue');
        $current++;
    }

    /**
     * Парсинг запятой
     *
     *             -
     * <option=bold, underscore></>
     *             -
     *
     * @param IToken[] $tokens
     */
    protected function parseCommaSeparator(
        bool &$finish,
        string &$source,
        int &$current,
        string &$image,
        ?int &$type,
        array &$tokens,
        bool &$quote,
        bool &$single
    ): void {
        $symbol = mb_substr($source, $current, 1);
        $image = $symbol;
        $type = Token::T_COMMA_SEPARATOR;
        $this->setParseFunction('parseValue');
        $current++;
    }

    /**
     * Парсинг закрывающего тега
     *
     *                     ---
     * <color=red;bg=white></>
     *                     ---
     *
     * @param IToken[] $tokens
     */
    protected function parseEndTagStyle(
        bool &$finish,
        string &$source,
        int &$current,
        string &$image,
        ?int &$type,
        array &$tokens,
        bool &$quote,
        bool &$single
    ): void {
        do {
            $symbol = mb_substr($source, $current, 1);
            $prevSymbol = mb_substr($source, $current - 1, 1);

            $loop = ($symbol !== '>' || $prevSymbol === '\\') && $current < mb_strlen($source);
            $image .= $symbol;
            $current++;
        } while ($loop);
        $current--;
        $type = Token::T_END_TAG_STYLE;
        $this->setParseFunction('parse');
    }

    /**
     * Парсинг значения
     *
     *        ---    -----
     * <color=red;bg=white></>
     *        ---    -----
     *
     * @param IToken[]    $tokens
     */
    protected function parseValue(
        bool &$finish,
        string &$source,
        int &$current,
        string &$image,
        ?int &$type,
        array &$tokens,
        bool &$quote,
        bool &$single
    ): void {
        do {
            $symbol = mb_substr($source, $current, 1);
            $prevSymbol = mb_substr($source, $current - 1, 1);

            if (preg_match('/[\s\t\n]/mui', $symbol) && !$quote && !$single) {
                $this->whiteSpaceReturn = 'parseValue';
                $this->setParseFunction('parseWhitespace');
                if ($image !== '') {
                    $type = Token::T_VALUE;
                }

                return;
            }

            if (($symbol === '"' || $symbol === '\'') && $prevSymbol !== '\\') {
                $this->quoteReturn = 'parseValue';
                $this->setParseFunction('parseQuote');
                if ($image !== '') {
                    $type = Token::T_VALUE;
                }

                return;
            }

            if ($symbol === ',' && $prevSymbol !== '\\' && !$quote && !$single) {
                $this->setParseFunction('parseCommaSeparator');
                if ($image !== '') {
                    $type = Token::T_VALUE;
                }

                return;
            }

            $loop = ($symbol !== '>' || $prevSymbol === '\\')
                && ($symbol !== ';' || $prevSymbol === '\\')
                && $current < mb_strlen($source);
            if ($loop) {
                $image .= $symbol;
            }
            $current++;
        } while ($loop);
        $current--;
        if ($image !== '') {
            $type = Token::T_VALUE;
        }
        $this->setParseFunction('parseStyle');
    }

    /**
     * Парсинг кавычек
     *
     *         -          -  -    -
     * <option="underscore", "bold";color=white></>
     *         -          -  -    -
     *
     * @param IToken[]    $tokens
     */
    protected function parseQuote(
        bool &$finish,
        string &$source,
        int &$current,
        string &$image,
        ?int &$type,
        array &$tokens,
        bool &$quote,
        bool &$single
    ): void {
        $symbol = mb_substr($source, $current, 1);
        $type = Token::T_QUOTE;
        $image = $symbol;
        if ($image === '"' && !$single) {
            $quote = !$quote;
        }
        if ($image === '\'' && !$quote) {
            $single = !$single;
        }
        $current++;
        $this->setParseFunction($this->quoteReturn);
    }

    /**
     * Парсинг стилей
     *
     *  -----     --
     * <color=red;bg=white></>
     *  -----     --
     *
     * @param IToken[]    $tokens
     */
    protected function parseStyle(
        bool &$finish,
        string &$source,
        int &$current,
        string &$image,
        ?int &$type,
        array &$tokens,
        bool &$quote,
        bool &$single
    ): void {
        do {
            $symbol = mb_substr($source, $current, 1);
            $prevSymbol = mb_substr($source, $current - 1, 1);

            if (preg_match('/[\s\t\n]/mui', $symbol)) {
                $this->whiteSpaceReturn = 'parseStyle';
                $this->setParseFunction('parseWhitespace');
                if ($image !== '') {
                    $this->checkKeywords($image, $type);
                }

                return;
            }
            if ($symbol === ';') {
                $this->setParseFunction('parseSemicolon');
                if ($image !== '') {
                    $this->checkKeywords($image, $type);
                }

                return;
            }
            if ($symbol === '=') {
                $this->setParseFunction('parseAssigment');
                if ($image !== '') {
                    $this->checkKeywords($image, $type);
                }

                return;
            }

            $loop = ($symbol !== '>' || $prevSymbol === '\\') && $current < mb_strlen($source);
            if ($loop) {
                $image .= $symbol;
            }
            $current++;
        } while ($loop);
        $current--;
        if ($image !== '') {
            $this->checkKeywords($image, $type);
        }
        $this->setParseFunction('parseCloseTagStyle');
    }

    /**
     * Проверяем на ключевые слова
     */
    protected function checkKeywords(string $image, ?int &$type): void
    {
        if (array_key_exists(mb_strtolower($image), static::$keywords)) {
            $type = static::$keywords[mb_strtolower($image)];

            return;
        }
        $type = Token::T_STYLE_NAME;
    }

    /**
     * Парсинг пробела
     *            -
     * <color=red; bg=white></>
     *            -
     *
     * @param IToken[]    $tokens
     */
    protected function parseWhitespace(
        bool &$finish,
        string &$source,
        int &$current,
        string &$image,
        ?int &$type,
        array &$tokens,
        bool &$quote,
        bool &$single
    ): void {
        $type = Token::T_WHITESPACE;
        do {
            $symbol = mb_substr($source, $current, 1);
            $loop = preg_match('/[\s\t\n]/mui', $symbol) && $current < mb_strlen($source);
            if ($loop) {
                $image .= $symbol;
            }
            $current++;
        } while ($loop);
        $current--;
        $this->setParseFunction($this->whiteSpaceReturn);
    }

    /**
     * @inheritDoc
     */
    public static function getTokenFactory()
    {
        return TokenFactory::class;
    }
}
