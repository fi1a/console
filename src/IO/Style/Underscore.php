<?php

declare(strict_types=1);

namespace Fi1a\Console\IO\Style;

/**
 * Нижнее подчеркивание
 */
class Underscore extends AbstractOption
{
    public const NAME = 'underscore';

    /**
     * @inheritDoc
     */
    public function getCode(): string
    {
        return '4';
    }

    /**
     * @inheritDoc
     */
    public function getDefaultCode(): string
    {
        return '24';
    }
}
