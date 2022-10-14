<?php

declare(strict_types=1);

namespace Fi1a\Console\IO;

use Fi1a\Console\IO\Style\StyleInterface;
use InvalidArgumentException;

/**
 * Стек стилей
 */
class FormatterStyleStack
{
    /**
     * @var StyleInterface[]
     */
    private $stack = [];

    /**
     * Добавления значения в стек
     */
    public function push(StyleInterface $style): void
    {
        $this->stack[] = $style;
    }

    /**
     * @return StyleInterface|null
     */
    public function pop(?StyleInterface $style = null)
    {
        if (is_null($style)) {
            return array_pop($this->stack);
        }
        foreach (array_reverse($this->stack, true) as $index => $stacked) {
            if ($style->apply('') === $stacked->apply('')) {
                $this->stack = array_slice($this->stack, 0, (int) $index);

                return $stacked;
            }
        }

        throw new InvalidArgumentException('Некорректное вложение стилей');
    }

    /**
     * Возвращает текущий стиль
     *
     * @return StyleInterface|false
     */
    public function getCurrent()
    {
        if (!count($this->stack)) {
            return false;
        }

        return $this->stack[count($this->stack) - 1];
    }
}
