<?php

declare(strict_types=1);

namespace Fi1a\Console\IO;

/**
 * Курсор
 */
interface CursorInterface
{
    /**
     * Конструктор
     */
    public function __construct(ConsoleOutputInterface $output);

    /**
     * Вернуть вывод
     */
    public function getOutput(): ConsoleOutputInterface;

    /**
     * Установить вывод
     */
    public function setOutput(ConsoleOutputInterface $output): bool;

    /**
     * Очистить консоль
     */
    public function clear(): bool;

    /**
     * Звучит 'звонок'
     */
    public function bell(): bool;

    /**
     * Переместить курсор в "домашнюю" позицию
     */
    public function home(): bool;

    /**
     * Переместить курсор
     */
    public function move(int $x, int $y): bool;

    /**
     * Переместить курсор
     */
    public function moveTo(int $x, int $y): bool;

    /**
     * Показать курсор
     */
    public function showCursor(): bool;

    /**
     * Спрятать курсор
     */
    public function hideCursor(): bool;

    /**
     * Установить заголовок
     */
    public function setTitle(string $title): bool;
}
