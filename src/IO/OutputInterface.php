<?php

declare(strict_types=1);

namespace Fi1a\Console\IO;

use Fi1a\Console\IO\Style\StyleInterface;

/**
 * Вывод
 */
interface OutputInterface
{
    public const VERBOSE_NONE = 0;

    public const VERBOSE_NORMAL = 1;

    public const VERBOSE_HIGHT = 2;

    public const VERBOSE_HIGHTEST = 3;

    public const VERBOSE_DEBUG = 4;

    /**
     * Вывод
     *
     * @param string|string[] $messages
     * @param mixed[] $variables
     * @param string|StyleInterface|null $style
     */
    public function write(
        $messages,
        array $variables = [],
        $style = null,
        bool $newLine = false,
        int $verbose = self::VERBOSE_NORMAL
    ): bool;

    /**
     * Вывод с переводом строки
     *
     * @param string|string[] $messages
     * @param mixed[] $variables
     * @param string|StyleInterface|null $style
     */
    public function writeln(
        $messages,
        array $variables = [],
        $style = null,
        int $verbose = self::VERBOSE_NORMAL
    ): bool;

    /**
     * Возвращает класс форматирования
     */
    public function getFormatter(): FormatterInterface;

    /**
     * Устанавливает класс форматирования
     */
    public function setFormatter(FormatterInterface $formatter): bool;

    /**
     * Используется оформление вывода
     */
    public function isDecorated(): bool;

    /**
     * Устанавливает флаг оформления вывода
     */
    public function setDecorated(bool $decorated): bool;

    /**
     * Установить уровень подробности вывода
     */
    public function setVerbose(int $verbose): bool;

    /**
     * Вернуть уровень подробности вывода
     */
    public function getVerbose(): int;
}
