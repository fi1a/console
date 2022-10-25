<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\ListComponent;

use Fi1a\Console\Component\ComponentInterface;
use Fi1a\Console\IO\ConsoleOutputInterface;

/**
 * Список
 */
interface ListComponentInterface extends ComponentInterface
{
    /**
     * Конструктор
     *
     * @param string[]|ComponentInterface[]|string[][]|ComponentInterface[][] $items
     */
    public function __construct(ConsoleOutputInterface $output, ListStyleInterface $style, array $items = []);

    /**
     * Вернуть вывод
     */
    public function getOutput(): ConsoleOutputInterface;

    /**
     * Установить вывод
     */
    public function setOutput(ConsoleOutputInterface $output): bool;

    /**
     * Установить стиль
     */
    public function setStyle(ListStyleInterface $style): bool;

    /**
     * Вернуть стиль
     */
    public function getStyle(): ListStyleInterface;

    /**
     * Установить элементы списка
     *
     * @param string[]|ComponentInterface[]|string[][]|ComponentInterface[][] $items
     */
    public function setItems(array $items): bool;

    /**
     * Добавить элемент списка
     *
     * @param string|ComponentInterface|string[]|ComponentInterface[] $text
     */
    public function addItem($text): bool;

    /**
     * Вернуть элементы списка
     *
     * @return string[][]|ComponentInterface[][]
     */
    public function getItems(): array;
}
