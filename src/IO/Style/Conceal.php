<?php

declare(strict_types=1);

namespace Fi1a\Console\IO\Style;

/**
 * Скрытый
 */
class Conceal extends AbstractOption
{
    /**
     * @inheritDoc
     */
    public function getCode(): string
    {
        return '8';
    }

    /**
     * @inheritDoc
     */
    public static function getName(): string
    {
        return 'conceal';
    }
}
