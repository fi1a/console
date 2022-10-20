<?php

declare(strict_types=1);

namespace Fi1a\Console\IO\Formatter\AST;

use Fi1a\Console\IO\Formatter\AST\Exception\SyntaxErrorException;
use Fi1a\Console\IO\Formatter\Tokenizer\Token;
use Fi1a\Console\IO\Formatter\Tokenizer\Tokenizer;
use Fi1a\Tokenizer\IToken;
use Fi1a\Tokenizer\ITokenizer;

/**
 * AST
 */
class AST implements ASTInterface
{
    /**
     * @var SymbolsInterface
     */
    private $symbols;

    /**
     * @var StylesInterface
     */
    private $styles;

    /**
     * @var array|Style[]|null
     */
    private $stylesCollection;

    /**
     * @inheritDoc
     * @psalm-suppress PossiblyInvalidMethodCall
     */
    public function __construct(string $format, ?array $stylesCollection = [], ?StyleInterface $preDefineStyle = null)
    {
        $this->symbols = new Symbols(SymbolInterface::class);
        $this->styles = new Styles(StyleInterface::class);
        $this->stylesCollection = $stylesCollection;
        if ($preDefineStyle) {
            $this->styles->add($preDefineStyle);
        }
        $tokenizer = new Tokenizer($format);
        while (($token = $tokenizer->next()) !== ITokenizer::T_EOF) {
            /**
             * @var IToken $token
             */
            if ($token->getType() === Token::T_TEXT) {
                $this->text($token);

                continue;
            }
            if ($token->getType() === Token::T_OPEN_TAG_STYLE) {
                $this->style($tokenizer);

                continue;
            }
            if ($token->getType() === Token::T_END_TAG_STYLE) {
                if ($this->styles->count() > 0) {
                    $this->styles->delete($this->styles->count() - 1);
                    $this->styles->resetKeys();
                } else {
                    throw new SyntaxErrorException('Ошибка в закрытых тегах форматирования');
                }

                continue;
            }
        }
        if ($preDefineStyle && $this->styles->count() > 0) {
            $this->styles->delete($this->styles->count() - 1);
            $this->styles->resetKeys();
        }
        if ($this->styles->count() > 0) {
            throw new SyntaxErrorException('Ошибка в открытых тегах форматирования');
        }
    }

    /**
     * Стили
     */
    private function style(ITokenizer $tokenizer): void
    {
        $style = new Style();
        do {
            $token = $this->next($tokenizer);
            if (
                !in_array(
                    $token->getType(),
                    [Token::T_OPTION, Token::T_STYLE_NAME, Token::T_COLOR, Token::T_BG]
                )
            ) {
                throw new SyntaxErrorException(sprintf(
                    'Синтаксическая ошибка (%d, %d)',
                    $token->getEndLine(),
                    $token->getEndColumn()
                ));
            }
            $key = $token->getType();
            switch ($key) {
                case Token::T_STYLE_NAME:
                    $style->setStyleName($token->getImage());
                    if (
                        !$this->stylesCollection
                        || !isset($this->stylesCollection[mb_strtolower((string) $style->getStyleName())])
                    ) {
                        throw new SyntaxErrorException(sprintf(
                            'Стиль "%s" не найден (%d, %d)',
                            (string) $style->getStyleName(),
                            $token->getEndLine(),
                            $token->getEndColumn()
                        ));
                    }
                    /**
                     * @var StyleInterface $styleCollectionItem
                     * @psalm-suppress PossiblyNullArrayAccess
                     */
                    $styleCollectionItem = $this->stylesCollection[mb_strtolower((string) $style->getStyleName())];
                    $style->setColor($styleCollectionItem->getColor());
                    $style->setBackground($styleCollectionItem->getBackground());
                    $style->setOptions($styleCollectionItem->getOptions());

                    break;
                case Token::T_OPTION:
                    $options = [];
                    do {
                        $option = $this->value($tokenizer);
                        $token = $this->next($tokenizer);
                        if ($option === false) {
                            $options = $option;

                            break;
                        }
                        $options[] = $option;
                    } while ($token->getType() === Token::T_COMMA_SEPARATOR);
                    $style->setOptions($options);
                    $tokenizer->prev();

                    break;
                case Token::T_COLOR:
                    $style->setColor($this->value($tokenizer));

                    break;
                case Token::T_BG:
                    $style->setBackground($this->value($tokenizer));

                    break;
            }
            $token = $this->next($tokenizer);
            if ($token->getType() !== Token::T_SEMICOLON && $token->getType() !== Token::T_CLOSE_TAG_STYLE) {
                throw new SyntaxErrorException(sprintf(
                    'Синтаксическая ошибка (%d, %d)',
                    $token->getEndLine(),
                    $token->getEndColumn()
                ));
            }
            $loop = $token->getType() === Token::T_SEMICOLON;
        } while ($loop);

        $this->styles->add($style);
    }

    /**
     * Возвращает значение
     *
     * @return false|string
     *
     * @psalm-suppress PossiblyInvalidMethodCall
     */
    private function value(ITokenizer $tokenizer)
    {
        $token = $this->next($tokenizer);
        if ($token->getType() === Token::T_SEMICOLON || $token->getType() === Token::T_CLOSE_TAG_STYLE) {
            $tokenizer->prev();

            return false;
        }
        if ($token->getType() !== Token::T_ASSIGMENT && $token->getType() !== Token::T_VALUE) {
            throw new SyntaxErrorException(sprintf(
                'Синтаксическая ошибка (%d, %d)',
                $tokenizer->current()->getEndLine(),
                $tokenizer->current()->getEndColumn()
            ));
        }
        if ($token->getType() === Token::T_ASSIGMENT) {
            $token = $this->next($tokenizer);
        }
        if ($token->getType() !== Token::T_VALUE) {
            throw new SyntaxErrorException(sprintf(
                'Синтаксическая ошибка (%d, %d)',
                $tokenizer->current()->getEndLine(),
                $tokenizer->current()->getEndColumn()
            ));
        }

        return $token->getImage();
    }

    /**
     * Следующий токен
     *
     * @psalm-suppress PossiblyInvalidMethodCall
     */
    private function next(ITokenizer $tokenizer): IToken
    {
        $token = $tokenizer->next();
        if ($token === ITokenizer::T_EOF) {
            $token = $tokenizer->current();

            throw new SyntaxErrorException(sprintf(
                'Синтаксическая ошибка (%d, %d)',
                $token->getEndLine(),
                $token->getEndColumn()
            ));
        }
        if ($token->getType() === Token::T_WHITESPACE) {
            $token = $tokenizer->next();
            if ($token === ITokenizer::T_EOF) {
                $token = $tokenizer->current();

                throw new SyntaxErrorException(sprintf(
                    'Синтаксическая ошибка (%d, %d)',
                    $token->getEndLine(),
                    $token->getEndColumn()
                ));
            }
        }
        assert($token instanceof IToken);

        return $token;
    }

    /**
     * Текст
     */
    private function text(IToken $token): void
    {
        $current = 0;
        while ($current < mb_strlen($token->getImage())) {
            $string = mb_substr($token->getImage(), $current, 1);
            $symbol = new Symbol($string, $this->styles->getArrayCopy());
            $this->symbols->add($symbol);

            $current++;
        }
    }

    /**
     * @inheritDoc
     */
    public function getSymbols(): SymbolsInterface
    {
        return $this->symbols;
    }
}
