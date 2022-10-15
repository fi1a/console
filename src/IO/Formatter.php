<?php

declare(strict_types=1);

namespace Fi1a\Console\IO;

use Fi1a\Console\IO\Style\ANSIStyle;
use Fi1a\Console\IO\Style\StyleInterface;
use InvalidArgumentException;

use const PREG_OFFSET_CAPTURE;
use const PREG_SET_ORDER;

class Formatter implements FormatterInterface
{
    /**
     * @var StyleInterface[]
     */
    private static $styles = [];

    /**
     * @var FormatterStyleStack
     */
    private $stack;

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
        $this->setStack(new FormatterStyleStack());
    }

    /**
     * @inheritDoc
     */
    public static function addStyle(string $name, StyleInterface $style): bool
    {
        if (static::hasStyle($name)) {
            return false;
        }
        static::$styles[$name] = $style;

        return true;
    }

    /**
     * @inheritDoc
     */
    public static function hasStyle(string $name): bool
    {
        return array_key_exists($name, static::$styles);
    }

    /**
     * @inheritDoc
     */
    public static function deleteStyle(string $name): bool
    {
        if (!static::hasStyle($name)) {
            return false;
        }

        unset(static::$styles[$name]);

        return true;
    }

    /**
     * @inheritDoc
     */
    public function getStyle(string $name)
    {
        if (static::hasStyle($name)) {
            return static::$styles[$name];
        }
        if (!preg_match_all('/([^=]+)=([^;]+)(;|$)/', $name, $matches, PREG_SET_ORDER)) {
            return false;
        }
        $style = $this->factoryStyle();
        foreach ($matches as $match) {
            array_shift($match);
            if ($match[0] === 'color') {
                $style->setColor($match[1]);

                continue;
            }
            if ($match[0] === 'bg') {
                $style->setBackground($match[1]);

                continue;
            }
            $style->setOption($match[1]);
        }

        return $style;
    }

    /**
     * @inheritDoc
     */
    public function format(string $message): string
    {
        $offset = 0;
        $output = '';
        $tagRegex = '[a-z][a-z0-9\_\=\;\-\#]*+';
        preg_match_all("#<(($tagRegex) | /($tagRegex)?)>#ix", $message, $matches, PREG_OFFSET_CAPTURE);

        foreach ($matches[0] as $i => $match) {
            $pos = $match[1];
            $text = $match[0];
            $output .= $this->applyCurrent(mb_substr($message, $offset, $pos - $offset));
            $offset = $pos + mb_strlen($text);

            if ($open = $text[1] !== '/') {
                $tag = $matches[1][$i][0];
            } else {
                $tag = $matches[3][$i][0] ?? '';
            }

            if (!$open && !$tag) {
                $this->getStack()->pop();
            } elseif (($style = $this->getStyle(mb_strtolower($tag))) === false) {
                $output .= $this->applyCurrent($text);
            } elseif ($open) {
                $this->getStack()->push($style);
            } else {
                $this->getStack()->pop($style);
            }
        }

        return $output . $this->applyCurrent(mb_substr($message, $offset));
    }

    /**
     * Устанавливает экземпляр класса стека
     */
    private function setStack(FormatterStyleStack $stack): bool
    {
        $this->stack = $stack;

        return true;
    }

    /**
     * Возвращает экземпляр класса стека
     */
    private function getStack(): FormatterStyleStack
    {
        return $this->stack;
    }

    /**
     * Применить текущий стиль
     */
    private function applyCurrent(string $message): string
    {
        $style = $this->getStack()->getCurrent();
        if (!mb_strlen($message) || !$style) {
            return $message;
        }

        return $style->apply($message);
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
