<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\PanelComponent;

use InvalidArgumentException;

/**
 * Реестр оформления границ
 */
class BorderRegistry implements BorderRegistryInterface
{
    /**
     * @var BorderInterface[]
     */
    private static $borders = [];

    /**
     * @inheritDoc
     */
    public static function add(string $name, BorderInterface $border): bool
    {
        if (static::has($name)) {
            return false;
        }

        static::$borders[mb_strtolower($name)] = $border;

        return true;
    }

    /**
     * @inheritDoc
     */
    public static function has(string $name): bool
    {
        return array_key_exists(mb_strtolower($name), static::$borders);
    }

    /**
     * @inheritDoc
     */
    public static function get(string $name): BorderInterface
    {
        if (!static::has($name)) {
            throw new InvalidArgumentException(sprintf('Неизвестное оформление границ "%s"', $name));
        }

        return static::$borders[mb_strtolower($name)];
    }

    /**
     * @inheritDoc
     */
    public static function delete(string $name): bool
    {
        if (!static::has($name)) {
            return false;
        }

        unset(static::$borders[mb_strtolower($name)]);

        return true;
    }
}
