<?php

declare(strict_types=1);

namespace Fi1a\Console\IO;

/**
 * Потоковый ввод из консоли
 *
 * @codeCoverageIgnore
 */
class ConsoleInput extends StreamConsoleInput
{
    /**
     * @inheritDoc
     */
    public function __construct()
    {
        parent::__construct(new Stream('php://stdin', 'r'));
    }
}
