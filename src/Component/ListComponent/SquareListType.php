<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\ListComponent;

/**
 * В качестве маркера выступает закрашенный квадрат.
 */
class SquareListType implements ListTypeInterface
{
    /**
     * @inheritDoc
     */
    public function getSymbol(int $index): string
    {
        return '□';
    }
}
