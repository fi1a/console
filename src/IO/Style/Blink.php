<?php

declare(strict_types=1);

namespace Fi1a\Console\IO\Style;

/**
 * Мигание
 */
class Blink extends AbstractOption
{
    public const NAME = 'blink';

    /**
     * @inheritDoc
     */
    public function getCode(): string
    {
        return '5';
    }
}
