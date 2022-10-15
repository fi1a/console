<?php

declare(strict_types=1);

namespace Fi1a\Console\IO;

/**
 * Ввод из массива аргументов CLI
 */
class ArgvInput extends ArrayInput
{
    /**
     * Конструктор
     *
     * @param string[] $array
     */
    public function __construct(array $array)
    {
        array_shift($array);
        parent::__construct($array);
    }
}
