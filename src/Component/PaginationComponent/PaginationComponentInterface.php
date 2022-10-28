<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\PaginationComponent;

use Fi1a\Console\Component\ComponentInterface;
use Fi1a\Console\IO\ConsoleOutputInterface;
use Fi1a\Console\IO\InputInterface;

/**
 * Постраничная навигация
 */
interface PaginationComponentInterface extends ComponentInterface
{
    /**
     * Конструктор
     */
    public function __construct(
        ConsoleOutputInterface $output,
        InputInterface $stream,
        PaginationStyleInterface $style
    );

    /**
     * Установить стиль
     */
    public function setStyle(PaginationStyleInterface $style): bool;

    /**
     * Вернуть стиль
     */
    public function getStyle(): PaginationStyleInterface;

    /**
     * Вернуть вывод
     */
    public function getOutput(): ConsoleOutputInterface;

    /**
     * Установить вывод
     */
    public function setOutput(ConsoleOutputInterface $output): bool;

    /**
     * Вернуть ввод
     */
    public function getInputStream(): InputInterface;

    /**
     * Установить ввод
     */
    public function setInputStream(InputInterface $input): bool;

    /**
     * Возвращает кол-во страниц
     */
    public function getCount(): int;

    /**
     * Устанавливает кол-во страниц
     */
    public function setCount(int $pages): bool;

    /**
     * Устанавливает текущую страницу
     */
    public function setCurrent(int $page): bool;

    /**
     * Возвращает текущую страницу
     */
    public function getCurrent(): int;

    /**
     * Валидация для цикла
     */
    public function isValid(): bool;
}
