<?php

declare(strict_types=1);

namespace Fi1a\Console\IO;

use Fi1a\Tokenizer\ConsoleLine\Token;
use Fi1a\Tokenizer\ConsoleLine\Tokenizer;
use Fi1a\Tokenizer\ITokenizer;

/**
 * Ввод из строки
 */
class StringInputArguments extends AbstractInputArguments
{
    /**
     * Конструктор
     */
    public function __construct(string $input)
    {
        $tokenizer = new Tokenizer($input);
        $tokens = [];
        while (($token = $tokenizer->next()) !== ITokenizer::T_EOF) {
            /** @psalm-suppress PossiblyInvalidMethodCall */
            if ($token->getType() === Token::T_QUOTE || $token->getType() === Token::T_WHITE_SPACE) {
                continue;
            }
            /** @psalm-suppress PossiblyInvalidMethodCall */
            if ($token->getType() === Token::T_EQUAL || $token->getType() === Token::T_OPTION_VALUE) {
                $tokens[count($tokens) - 1] .= $token->getImage();

                continue;
            }
            /** @psalm-suppress PossiblyInvalidMethodCall */
            $tokens[] = $token->getImage();
        }

        $this->setTokens($tokens);
    }
}
