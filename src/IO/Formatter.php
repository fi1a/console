<?php

declare(strict_types=1);

namespace Fi1a\Console\IO;

use Fi1a\Console\IO\AST\AST;
use Fi1a\Console\IO\AST\Symbol;
use Fi1a\Console\IO\AST\SymbolsInterface;
use Fi1a\Console\IO\Style\ANSIStyle;
use Fi1a\Console\IO\Style\ASTStyleConverter;
use Fi1a\Console\IO\Style\IOStyleConverter;
use Fi1a\Console\IO\Style\StyleInterface;
use InvalidArgumentException;

use const PHP_EOL;

/**
 * Форматирование в консоли
 */
class Formatter extends AbstractFormatter
{
    /**
     * @var StyleInterface[]
     */
    private static $styles = [];

    /**
     * @var string
     */
    private $styleClass;

    /**
     * Конструктор
     */
    public function __construct(?string $styleClass = null)
    {
        if (is_null($styleClass)) {
            $styleClass = ANSIStyle::class;
        }
        $this->setStyleClass($styleClass);
    }

    /**
     * @inheritDoc
     */
    public static function addStyle(string $name, StyleInterface $style): bool
    {
        if (static::hasStyle($name)) {
            return false;
        }
        static::$styles[mb_strtolower($name)] = $style;

        return true;
    }

    /**
     * @inheritDoc
     */
    public static function hasStyle(string $name): bool
    {
        return array_key_exists(mb_strtolower($name), static::$styles);
    }

    /**
     * @inheritDoc
     */
    public static function deleteStyle(string $name): bool
    {
        if (!static::hasStyle($name)) {
            return false;
        }

        unset(static::$styles[mb_strtolower($name)]);

        return true;
    }

    /**
     * @inheritDoc
     */
    public static function allStyles(): array
    {
        return static::$styles;
    }

    /**
     * @inheritDoc
     */
    public static function getStyle(string $name)
    {
        if (!static::hasStyle($name)) {
            return false;
        }

        return static::$styles[mb_strtolower($name)];
    }

    /**
     * @inheritDoc
     */
    public function formatSymbols(SymbolsInterface $symbols): string
    {
        $output = '';
        $string = '';
        $prevStyle = null;
        foreach ($symbols as $symbol) {
            assert($symbol instanceof Symbol);
            $styleAST = $symbol->getStyles()->getComputedStyle();
            $style = IOStyleConverter::convert($styleAST, $this->factoryStyle());
            if ((!$prevStyle || $style->apply('') === $prevStyle->apply('')) && $symbol->getValue() !== PHP_EOL) {
                $string .= $symbol->getValue();
            } else {
                $output .= $prevStyle ? $prevStyle->apply($string) : $style->apply($string);
                if ($symbol->getValue() === PHP_EOL) {
                    $string = '';
                    $output .= $symbol->getValue();
                } else {
                    $string = $symbol->getValue();
                }
            }

            $prevStyle = $style;
        }
        if ($prevStyle) {
            $output .= $prevStyle->apply($string);
        }

        return $output;
    }

    /**
     * @inheritDoc
     */
    public function format(string $message, $style = null): string
    {
        if (is_string($style)) {
            $styleName = $style;
            $style = static::getStyle($styleName);
            if (!$style) {
                throw new InvalidArgumentException(
                    sprintf('Стиль "%s" не найден', $styleName)
                );
            }
        }
        if ($style) {
            $style = ASTStyleConverter::convert($style);
        }
        $ast = new AST(
            $message,
            ASTStyleConverter::convertArray(static::allStyles()),
            $style
        );

        return $this->formatSymbols($ast->getSymbols());
    }

    /**
     * Устанавливает используемый класс реализующий интерфейс IStyle
     */
    private function setStyleClass(string $styleClass): bool
    {
        if (!is_subclass_of($styleClass, StyleInterface::class)) {
            throw new InvalidArgumentException('The class must implement the interface ' . StyleInterface::class);
        }
        $this->styleClass = $styleClass;

        return true;
    }

    /**
     * Создает экземпляр класса реализующего интерфейс IStyle
     */
    private function factoryStyle(): StyleInterface
    {
        /**
         * @var StyleInterface $instance
         * @psalm-suppress InvalidStringClass
         */
        $instance = new $this->styleClass();

        return $instance;
    }
}
