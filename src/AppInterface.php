<?php

declare(strict_types=1);

namespace Fi1a\Console;

use Fi1a\Console\IO\ConsoleOutputInterface;
use Fi1a\Console\IO\InputArgumentsInterface;
use Fi1a\Console\IO\InputInterface;

interface AppInterface
{
    /**
     * Конструктор
     */
    public function __construct(
        ?InputArgumentsInterface $input = null,
        ?ConsoleOutputInterface $output = null,
        ?InputInterface $stream = null
    );

    /**
     * Запуск комманды
     */
    public function run(?string $command = null): int;
}
