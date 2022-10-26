<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\SpinnerComponent;

/**
 * Спиннер
 */
class GrowHorizontalSpinner implements SpinnerInterface
{
    /**
     * @inheritDoc
     */
    public function getFrames(): array
    {
        return ['▏', '▎', '▍', '▌', '▋', '▊', '▉', '▊', '▋', '▌', '▍', '▎'];
    }
}
