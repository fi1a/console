<?php

declare(strict_types=1);

namespace Fi1a\Console\IO\Style;

/**
 * Расширенный стиль для консольного вывода
 */
class ExtendedStyle extends ANSIStyle
{
    /**
     * @inheritDoc
     */
    public function getColor(): ColorInterface
    {
        return new ExtendedColor($this->color);
    }

    /**
     * @inheritDoc
     */
    public function getBackground(): ColorInterface
    {
        return new ExtendedColor($this->background);
    }
}
