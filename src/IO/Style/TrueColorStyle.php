<?php

declare(strict_types=1);

namespace Fi1a\Console\IO\Style;

/**
 * TrueColor стиль для консольного вывода
 */
class TrueColorStyle extends ANSIStyle
{
    /**
     * @inheritDoc
     */
    public function getColor(): ColorInterface
    {
        return new TrueColor($this->color);
    }

    /**
     * @inheritDoc
     */
    public function getBackground(): ColorInterface
    {
        return new TrueColor($this->background);
    }
}
