<?php

declare(strict_types=1);

namespace Fi1a\Console\Component;

use Fi1a\Console\IO\ConsoleOutputInterface;

/**
 * Вывод
 */
trait OutputTrait
{
    /**
     * @var ConsoleOutputInterface
     * @psalm-suppress PropertyNotSetInConstructor
     */
    private $output;

    /**
     * Вернуть вывод
     */
    public function getOutput(): ConsoleOutputInterface
    {
        return $this->output;
    }

    /**
     * Установить вывод
     */
    public function setOutput(ConsoleOutputInterface $output): bool
    {
        $this->output = $output;

        return true;
    }
}
