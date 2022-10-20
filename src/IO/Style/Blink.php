<?php

declare(strict_types=1);

namespace Fi1a\Console\IO\Style;

/**
 * Мигание
 */
class Blink extends AbstractOption
{
    /**
     * @inheritDoc
     */
    public function getCode(): string
    {
        return '5';
    }

    /**
     * @inheritDoc
     */
    public static function getName(): string
    {
        return 'blink';
    }
}
