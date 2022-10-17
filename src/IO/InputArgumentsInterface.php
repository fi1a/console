<?php

declare(strict_types=1);

namespace Fi1a\Console\IO;

/**
 * Ввод
 */
interface InputArgumentsInterface
{
    /**
     * Токены в виде массива
     *
     * @return string[]
     */
    public function getTokens(): array;

    /**
     * Установить токены
     *
     * @param string[] $tokens
     */
    public function setTokens(array $tokens): bool;
}
