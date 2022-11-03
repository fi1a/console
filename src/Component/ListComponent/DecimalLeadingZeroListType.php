<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\ListComponent;

/**
 * Порядковый номер с лидирующим нулем
 *
 * 01, 02, 03, 04, 05, …
 */
class DecimalLeadingZeroListType implements ListTypeInterface
{
    /**
     * @inheritDoc
     */
    public function getSymbol(int $index): string
    {
        return ($index + 1 < 10 ? '0' : '') . ($index + 1) . '.';
    }
}
