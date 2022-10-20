<?php

declare(strict_types=1);

namespace Fi1a\Console\IO\Style;

/**
 * Инверсия
 */
class Reverse extends AbstractOption
{
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
    public static function getName(): string
    {
        return 'reverse';
    }
}
