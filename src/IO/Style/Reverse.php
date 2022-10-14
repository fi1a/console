<?php

declare(strict_types=1);

namespace Fi1a\Console\IO\Style;

/**
 * Инверсия
 */
class Reverse extends AbstractOption
{
    public const NAME = 'reverse';

    /**
     * @inheritDoc
     */
    public function getCode(): string
    {
        return '7';
    }

    /**
     * @inheritDoc
     */
    public function getDefaultCode(): string
    {
        return '27';
    }
}
