<?php

declare(strict_types=1);

namespace Fi1a\Console\IO\Style;

/**
 * Скрытый
 */
class Conceal extends AbstractOption
{
    public const NAME = 'conceal';

    /**
     * @inheritDoc
     */
    public function getCode(): string
    {
        return '8';
    }
}
