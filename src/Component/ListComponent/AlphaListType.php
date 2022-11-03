<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\ListComponent;

/**
 * Алфавитный список
 */
abstract class AlphaListType implements ListTypeInterface
{
    /**
     * Алфавитный список
     */
    protected function getAlphaListType(int $index): string
    {
        $out = '';
        $to = (int) floor($index / 25);
        for ($dim = 0; $dim <= $to; $dim++) {
            if ($dim === $to) {
                $out .= chr(65 + ($index - $dim * 25));

                continue;
            }

            $out .= 'z';
        }

        $out .= '.';

        return $out;
    }
}
