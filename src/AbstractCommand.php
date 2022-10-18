<?php

declare(strict_types=1);

namespace Fi1a\Console;

/**
 * Команда
 */
abstract class AbstractCommand implements CommandInterface
{
    /**
     * @inheritDoc
     */
    public function description(): ?string
    {
        return null;
    }
}
