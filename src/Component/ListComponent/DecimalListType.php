<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\ListComponent;

/**
 * Порядковый номер
 *
 * 1, 2, 3, 4, 5, …
 */
class DecimalListType implements ListTypeInterface
{
    /**
     * @inheritDoc
     */
    public function getSymbol(int $index): string
    {
        return ($index + 1) . '.';
    }
}
