<?php

declare(strict_types=1);

namespace Fi1a\Unit\Console\IO\Tokenizer;

use Fi1a\Console\IO\Formatter\Tokenizer\Token;
use Fi1a\Console\IO\Formatter\Tokenizer\Tokenizer;
use Fi1a\Tokenizer\ITokenizer;
use PHPUnit\Framework\TestCase;

/**
 * Тестирование лексического анализатора
 */
class TokenizerTest extends TestCase
{
    /**
     * Данные для тестирования лексического анализатора
     *
     * @return mixed[]
     */
    public function dataTokenizer(): array
    {
        return [
            // 0
            [
                'text <',
                2,
                ['text ', '<',],
                [Token::T_TEXT, Token::T_OPEN_TAG_STYLE,],
            ],
            // 1
            [
                'text <color',
                3,
                ['text ', '<', 'color'],
                [Token::T_TEXT, Token::T_OPEN_TAG_STYLE, Token::T_COLOR,],
            ],
            // 2
            [
                'text <error>',
                4,
                ['text ', '<', 'error', '>'],
                [Token::T_TEXT, Token::T_OPEN_TAG_STYLE, Token::T_STYLE_NAME, Token::T_CLOSE_TAG_STYLE],
            ],
            // 3
            [
                'text <color=red>',
                6,
                ['text ', '<', 'color', '=', 'red', '>'],
                [
                    Token::T_TEXT, Token::T_OPEN_TAG_STYLE, Token::T_COLOR, Token::T_ASSIGMENT,
                    Token::T_VALUE, Token::T_CLOSE_TAG_STYLE,
                ],
            ],
            // 4
            [
                'text <color=red;bg=white>',
                10,
                ['text ', '<', 'color', '=', 'red', ';', 'bg', '=', 'white', '>'],
                [
                    Token::T_TEXT, Token::T_OPEN_TAG_STYLE, Token::T_COLOR, Token::T_ASSIGMENT,
                    Token::T_VALUE, Token::T_SEMICOLON, Token::T_BG, Token::T_ASSIGMENT,
                    Token::T_VALUE, Token::T_CLOSE_TAG_STYLE,
                ],
            ],
            // 5
            [
                'text <bg=white>',
                6,
                ['text ', '<', 'bg', '=', 'white', '>'],
                [
                    Token::T_TEXT, Token::T_OPEN_TAG_STYLE, Token::T_BG, Token::T_ASSIGMENT,
                    Token::T_VALUE, Token::T_CLOSE_TAG_STYLE,
                ],
            ],
            // 6
            [
                'text <option="bold">',
                8,
                ['text ', '<', 'option', '=', '"', 'bold', '"', '>'],
                [
                    Token::T_TEXT, Token::T_OPEN_TAG_STYLE, Token::T_OPTION, Token::T_ASSIGMENT,
                    Token::T_QUOTE, Token::T_VALUE, Token::T_QUOTE, Token::T_CLOSE_TAG_STYLE,
                ],
            ],
            // 7
            [
                'text <option="bold", "underscore">',
                13,
                ['text ', '<', 'option', '=', '"', 'bold', '"', ',', ' ', '"', 'underscore', '"', '>'],
                [
                    Token::T_TEXT, Token::T_OPEN_TAG_STYLE, Token::T_OPTION, Token::T_ASSIGMENT,
                    Token::T_QUOTE, Token::T_VALUE, Token::T_QUOTE, Token::T_COMMA_SEPARATOR, Token::T_WHITESPACE,
                    Token::T_QUOTE, Token::T_VALUE, Token::T_QUOTE, Token::T_CLOSE_TAG_STYLE,
                ],
            ],
            // 8
            [
                'text <option="bold", "underscore"> text',
                14,
                ['text ', '<', 'option', '=', '"', 'bold', '"', ',', ' ', '"', 'underscore', '"', '>', ' text'],
                [
                    Token::T_TEXT, Token::T_OPEN_TAG_STYLE, Token::T_OPTION, Token::T_ASSIGMENT,
                    Token::T_QUOTE, Token::T_VALUE, Token::T_QUOTE, Token::T_COMMA_SEPARATOR, Token::T_WHITESPACE,
                    Token::T_QUOTE, Token::T_VALUE, Token::T_QUOTE, Token::T_CLOSE_TAG_STYLE, Token::T_TEXT,
                ],
            ],
            // 9
            [
                'text <option="bold", "underscore"> text </>',
                15,
                ['text ', '<', 'option', '=', '"', 'bold', '"', ',', ' ', '"', 'underscore', '"', '>', ' text ', '</>'],
                [
                    Token::T_TEXT, Token::T_OPEN_TAG_STYLE, Token::T_OPTION, Token::T_ASSIGMENT,
                    Token::T_QUOTE, Token::T_VALUE, Token::T_QUOTE, Token::T_COMMA_SEPARATOR, Token::T_WHITESPACE,
                    Token::T_QUOTE, Token::T_VALUE, Token::T_QUOTE, Token::T_CLOSE_TAG_STYLE, Token::T_TEXT,
                    Token::T_END_TAG_STYLE,
                ],
            ],
            // 10
            [
                'text <option="bold", "underscore"><error>error</error> text </>',
                20,
                [
                    'text ', '<', 'option', '=', '"', 'bold', '"', ',', ' ', '"', 'underscore', '"', '>',
                    '<', 'error', '>', 'error', '</error>', ' text ', '</>',
                ],
                [
                    Token::T_TEXT, Token::T_OPEN_TAG_STYLE, Token::T_OPTION, Token::T_ASSIGMENT,
                    Token::T_QUOTE, Token::T_VALUE, Token::T_QUOTE, Token::T_COMMA_SEPARATOR, Token::T_WHITESPACE,
                    Token::T_QUOTE, Token::T_VALUE, Token::T_QUOTE, Token::T_CLOSE_TAG_STYLE,
                    Token::T_OPEN_TAG_STYLE, Token::T_STYLE_NAME, Token::T_CLOSE_TAG_STYLE, Token::T_TEXT,
                    Token::T_END_TAG_STYLE, Token::T_TEXT, Token::T_END_TAG_STYLE,
                ],
            ],
            // 11
            [
                'text <color=red;bg=white;option="bold", "underscore"> text',
                22,
                [
                    'text ', '<', 'color', '=', 'red', ';', 'bg', '=', 'white', ';',
                    'option', '=', '"', 'bold', '"', ',', ' ', '"', 'underscore', '"', '>', ' text',
                ],
                [
                    Token::T_TEXT, Token::T_OPEN_TAG_STYLE, Token::T_COLOR, Token::T_ASSIGMENT,
                    Token::T_VALUE, Token::T_SEMICOLON, Token::T_BG, Token::T_ASSIGMENT,
                    Token::T_VALUE, Token::T_SEMICOLON, Token::T_OPTION, Token::T_ASSIGMENT,
                    Token::T_QUOTE, Token::T_VALUE, Token::T_QUOTE, Token::T_COMMA_SEPARATOR, Token::T_WHITESPACE,
                    Token::T_QUOTE, Token::T_VALUE, Token::T_QUOTE, Token::T_CLOSE_TAG_STYLE, Token::T_TEXT,
                ],
            ],
            // 12
            [
                'text < color = red ; bg = white >',
                18,
                [
                    'text ', '<', ' ', 'color', ' ', '=', ' ', 'red', ' ', ';', ' ', 'bg', ' ', '=', ' ',
                    'white', ' ', '>',
                ],
                [
                    Token::T_TEXT, Token::T_OPEN_TAG_STYLE, Token::T_WHITESPACE, Token::T_COLOR, Token::T_WHITESPACE,
                    Token::T_ASSIGMENT, Token::T_WHITESPACE, Token::T_VALUE, Token::T_WHITESPACE, Token::T_SEMICOLON,
                    Token::T_WHITESPACE, Token::T_BG, Token::T_WHITESPACE, Token::T_ASSIGMENT, Token::T_WHITESPACE,
                    Token::T_VALUE, Token::T_WHITESPACE, Token::T_CLOSE_TAG_STYLE,
                ],
            ],
            // 13
            [
                'text < color = " red " ; bg = \' white \' >',
                22,
                [
                    'text ', '<', ' ', 'color', ' ', '=', ' ', '"', ' red ', '"', ' ', ';', ' ', 'bg', ' ', '=', ' ',
                    '\'', ' white ', '\'', ' ', '>',
                ],
                [
                    Token::T_TEXT, Token::T_OPEN_TAG_STYLE, Token::T_WHITESPACE, Token::T_COLOR, Token::T_WHITESPACE,
                    Token::T_ASSIGMENT, Token::T_WHITESPACE, Token::T_QUOTE, Token::T_VALUE, Token::T_QUOTE,
                    Token::T_WHITESPACE, Token::T_SEMICOLON, Token::T_WHITESPACE, Token::T_BG, Token::T_WHITESPACE,
                    Token::T_ASSIGMENT, Token::T_WHITESPACE, Token::T_QUOTE, Token::T_VALUE, Token::T_QUOTE,
                    Token::T_WHITESPACE, Token::T_CLOSE_TAG_STYLE,
                ],
            ],
            // 14
            [
                'text <option=red,white>',
                8,
                ['text ', '<', 'option', '=', 'red', ',', 'white', '>'],
                [
                    Token::T_TEXT, Token::T_OPEN_TAG_STYLE, Token::T_OPTION, Token::T_ASSIGMENT,
                    Token::T_VALUE, Token::T_COMMA_SEPARATOR, Token::T_VALUE, Token::T_CLOSE_TAG_STYLE,
                ],
            ],
            // 15
            [
                '<color=black;bg;option>e</>',
                11,
                [
                    '<', 'color', '=', 'black', ';', 'bg', ';', 'option', '>', 'e', '</>',
                ],
                [
                    Token::T_OPEN_TAG_STYLE, Token::T_COLOR, Token::T_ASSIGMENT, Token::T_VALUE, Token::T_SEMICOLON,
                    Token::T_BG, Token::T_SEMICOLON, Token::T_OPTION, Token::T_CLOSE_TAG_STYLE, Token::T_TEXT,
                    Token::T_END_TAG_STYLE,
                ],
            ],
        ];
    }

    /**
     * Тестирование лексического анализатора
     *
     * @param string[] $images
     * @param int[] $types
     *
     * @dataProvider dataTokenizer
     */
    public function testTokenizer(string $source, int $count, array $images, array $types): void
    {
        $tokenizer = new Tokenizer($source);
        $imagesEquals = [];
        $typesEquals = [];
        $image = '';
        while (($token = $tokenizer->next()) !== ITokenizer::T_EOF) {
            $imagesEquals[] = $token->getImage();
            $typesEquals[] = $token->getType();
            $image .= $token->getImage();
        }

        $this->assertEquals($images, $imagesEquals);
        $this->assertEquals($types, $typesEquals);
        $this->assertEquals($source, $image);
        $this->assertEquals($count, $tokenizer->getCount());
    }
}
