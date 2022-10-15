<?php

declare(strict_types=1);

namespace Fi1a\Console\IO;

/**
 * Ввод из массива аргументов CLI
 */
class ArgvInputArguments extends ArrayInputArguments
{
    /**
     * Конструктор
     *
     * @param string[] $argv
     */
    public function __construct(array $argv)
    {
        array_shift($argv);
        parent::__construct($argv);
    }
}
