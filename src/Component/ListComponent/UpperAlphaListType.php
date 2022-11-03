<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\ListComponent;

/**
 * Алфавитный список заглавных букв
 *
 * A, B, C, D, E, …
 */
class UpperAlphaListType extends AlphaListType
{
    /**
     * @inheritDoc
     */
    public function getSymbol(int $index): string
    {
        return $this->getAlphaListType($index);
    }
}
