<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\SpinnerComponent;

use InvalidArgumentException;

/**
 * Коллекция спиннеров
 */
class SpinnerCollection implements SpinnerCollectionInterface
{
    /**
     * @var SpinnerInterface[]
     */
    private static $spinners = [];

    /**
     * @inheritDoc
     */
    public static function add(string $name, SpinnerInterface $spinner): bool
    {
        if (static::has($name)) {
            return false;
        }

        static::$spinners[mb_strtolower($name)] = $spinner;

        return true;
    }

    /**
     * @inheritDoc
     */
    public static function has(string $name): bool
    {
        return array_key_exists(mb_strtolower($name), static::$spinners);
    }

    /**
     * @inheritDoc
     */
    public static function get(string $name): SpinnerInterface
    {
        if (!static::has($name)) {
            throw new InvalidArgumentException(sprintf('Неизвестный спиннер "%s"', $name));
        }

        return static::$spinners[mb_strtolower($name)];
    }

    /**
     * @inheritDoc
     */
    public static function delete(string $name): bool
    {
        if (!static::has($name)) {
            return false;
        }

        unset(static::$spinners[mb_strtolower($name)]);

        return true;
    }
}
