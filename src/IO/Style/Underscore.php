<?php

declare(strict_types=1);

namespace Fi1a\Console\IO\Style;

/**
 * Нижнее подчеркивание
 */
class Underscore extends AbstractOption
{
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
    public static function getName(): string
    {
        return 'underscore';
    }
}
