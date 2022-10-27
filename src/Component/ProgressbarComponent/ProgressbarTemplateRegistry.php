<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\ProgressbarComponent;

use InvalidArgumentException;

/**
 * Реестр шаблонов
 */
class ProgressbarTemplateRegistry implements ProgressbarTemplateRegistryInterface
{
    /**
     * @var string[]
     */
    private static $templates = [];

    /**
     * @inheritDoc
     */
    public static function add(string $name, string $template): bool
    {
        if (static::has($name)) {
            return false;
        }

        static::$templates[mb_strtolower($name)] = $template;

        return true;
    }

    /**
     * @inheritDoc
     */
    public static function has(string $name): bool
    {
        return array_key_exists(mb_strtolower($name), static::$templates);
    }

    /**
     * @inheritDoc
     */
    public static function delete(string $name): bool
    {
        if (!static::has($name)) {
            return false;
        }

        unset(static::$templates[mb_strtolower($name)]);

        return true;
    }

    /**
     * @inheritDoc
     */
    public static function get(string $name): string
    {
        if (!static::has($name)) {
            throw new InvalidArgumentException(sprintf('Шаблон "%s" не найден', $name));
        }

        return static::$templates[mb_strtolower($name)];
    }
}
