<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\ListComponent;

/**
 * В качестве маркера элементов списка выступает закрашенный кружок.
 */
class DiscListType implements ListTypeInterface
{
    /**
     * @inheritDoc
     */
    public function getSymbol(int $index): string
    {
        return '●';
    }
}
