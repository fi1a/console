<?php

declare(strict_types=1);

namespace Fi1a\Console\IO;

/**
 * Абстрактный класс форматирования
 */
abstract class AbstractFormatter implements FormatterInterface
{
    /**
     * @inheritDoc
     */
    public static function addSlashes(string $message): string
    {
        return str_replace(['\\', '<'], ['\\\\', '\<'], $message);
    }
}
