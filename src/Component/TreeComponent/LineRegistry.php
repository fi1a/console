<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\TreeComponent;

use InvalidArgumentException;

/**
 * Реестр оформления линии дерева
 */
class LineRegistry implements LineRegistryInterface
{
    /**
     * @var LineInterface[]
     */
    private static $lines = [];

    /**
     * @inheritDoc
     */
    public static function add(string $name, LineInterface $listType): bool
    {
        if (static::has($name)) {
            return false;
        }

        static::$lines[mb_strtolower($name)] = $listType;

        return true;
    }

    /**
     * @inheritDoc
     */
    public static function has(string $name): bool
    {
        return array_key_exists(mb_strtolower($name), static::$lines);
    }

    /**
     * @inheritDoc
     */
    public static function get(string $name): LineInterface
    {
        if (!static::has($name)) {
            throw new InvalidArgumentException(sprintf('Неизвестное оформление линии "%s"', $name));
        }

        return static::$lines[mb_strtolower($name)];
    }

    /**
     * @inheritDoc
     */
    public static function delete(string $name): bool
    {
        if (!static::has($name)) {
            return false;
        }

        unset(static::$lines[mb_strtolower($name)]);

        return true;
    }
}
