<?php

declare(strict_types=1);

namespace Fi1a\Console\Component;

use Fi1a\Console\IO\InputInterface;

/**
 * Ввод
 */
trait InputStreamTrait
{
    /**
     * @var InputInterface
     * @psalm-suppress PropertyNotSetInConstructor
     */
    private $stream;

    /**
     * Вернуть ввод
     */
    public function getInputStream(): InputInterface
    {
        return $this->stream;
    }

    /**
     * Установить ввод
     */
    public function setInputStream(InputInterface $input): bool
    {
        $this->stream = $input;

        return true;
    }
}
