<?php

declare(strict_types=1);

namespace Fi1a\Console\IO\Style;

/**
 * Выделение жирным
 */
class Bold extends AbstractOption
{
    public const NAME = 'bold';

    /**
     * @inheritDoc
     */
    public function getCode(): string
    {
        return '1';
    }

    /**
     * @inheritDoc
     */
    public function getDefaultCode(): string
    {
        return '22';
    }
}
