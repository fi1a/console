<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\SpinnerComponent;

/**
 * Спиннер
 */
class LineSpinner implements SpinnerInterface
{
    /**
     * @inheritDoc
     */
    public function getFrames(): array
    {
        return ['-', '\\\\', '|', '/'];
    }
}
