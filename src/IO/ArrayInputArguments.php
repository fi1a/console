<?php

declare(strict_types=1);

namespace Fi1a\Console\IO;

/**
 * Ввод из массива
 */
class ArrayInputArguments extends AbstractInputArguments
{
    /**
     * Конструктор
     *
     * @param string[] $argv
     */
    public function __construct(array $argv)
    {
        $this->setTokens($argv);
    }
}
