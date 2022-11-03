<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\ListComponent;

/**
 * Алфавитный список
 *
 * a, b, c, d, e, …
 */
class LowerAlphaListType extends AlphaListType
{
    /**
     * @inheritDoc
     */
    public function getSymbol(int $index): string
    {
        return mb_strtolower($this->getAlphaListType($index));
    }
}
