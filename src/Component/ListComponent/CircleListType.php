<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\ListComponent;

/**
 * В качестве маркера выступает незакрашенный кружок.
 */
class CircleListType implements ListTypeInterface
{
    /**
     * @inheritDoc
     */
    public function getSymbol(int $index): string
    {
        return '○';
    }
}
