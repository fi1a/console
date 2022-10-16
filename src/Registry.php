<?php

declare(strict_types=1);

namespace Fi1a\Console;

/**
 * Реестр
 */
class Registry
{
    /**
     * @var string[]
     */
    private static $argv = [];

    /**
     * Аргументы
     *
     * @param string[] $argv
     */
    public static function setArgv(array $argv): bool
    {
        static::$argv = $argv;

        return true;
    }

    /**
     * Аргументы
     *
     * @return string[]
     */
    public static function getArgv(): array
    {
        return static::$argv;
    }
}
