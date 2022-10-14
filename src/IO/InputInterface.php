<?php

declare(strict_types=1);

namespace Fi1a\Console\IO;

/**
 * Ввод
 */
interface InputInterface
{
    /**
     * Токены в виде массива
     *
     * @return string[]
     */
    public function getTokens(): array;
}
