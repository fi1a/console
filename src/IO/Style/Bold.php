<?php

declare(strict_types=1);

namespace Fi1a\Console\IO\Style;

/**
 * Выделение жирным
 */
class Bold extends AbstractOption
{
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
    public static function getName(): string
    {
        return 'bold';
    }
}
