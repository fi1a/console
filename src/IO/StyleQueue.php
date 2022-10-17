<?php

declare(strict_types=1);

namespace Fi1a\Console\IO;

use Fi1a\Collection\TypedValueQueue;
use Fi1a\Console\IO\Style\StyleInterface;
use InvalidArgumentException;

/**
 * Очередь стилей
 */
class StyleQueue extends TypedValueQueue
{
    /**
     * @inheritDoc
     */
    public function pollEnd(?StyleInterface $style = null)
    {
        if (is_null($style)) {
            return parent::pollEnd();
        }

        foreach (array_reverse($this->storage, true) as $index => $stacked) {
            assert($stacked instanceof StyleInterface);
            if ($style->apply('') === $stacked->apply('')) {
                $this->storage = array_slice($this->storage, 0, (int) $index);

                return $stacked;
            }
        }

        throw new InvalidArgumentException('Некорректное вложение стилей');
    }
}
