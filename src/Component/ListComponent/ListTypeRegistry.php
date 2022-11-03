<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\ListComponent;

use InvalidArgumentException;

/**
 * Реестр оформления списка
 */
class ListTypeRegistry implements ListTypeRegistryInterface
{
    /**
     * @var ListTypeInterface[]
     */
    private static $listTypes = [];

    /**
     * @inheritDoc
     */
    public static function add(string $name, ListTypeInterface $listType): bool
    {
        if (static::has($name)) {
            return false;
        }

        static::$listTypes[mb_strtolower($name)] = $listType;

        return true;
    }

    /**
     * @inheritDoc
     */
    public static function has(string $name): bool
    {
        return array_key_exists(mb_strtolower($name), static::$listTypes);
    }

    /**
     * @inheritDoc
     */
    public static function get(string $name): ListTypeInterface
    {
        if (!static::has($name)) {
            throw new InvalidArgumentException(sprintf('Неизвестное оформление списка "%s"', $name));
        }

        return static::$listTypes[mb_strtolower($name)];
    }

    /**
     * @inheritDoc
     */
    public static function delete(string $name): bool
    {
        if (!static::has($name)) {
            return false;
        }

        unset(static::$listTypes[mb_strtolower($name)]);

        return true;
    }
}
