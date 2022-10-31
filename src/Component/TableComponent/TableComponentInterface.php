<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\TableComponent;

use Fi1a\Console\Component\ComponentInterface;
use Fi1a\Console\IO\ConsoleOutputInterface;

/**
 * Таблица
 */
interface TableComponentInterface extends ComponentInterface
{
    /**
     * Конструктор
     */
    public function __construct(ConsoleOutputInterface $output, TableStyleInterface $style);

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
    public function setStyle(TableStyleInterface $style): bool;

    /**
     * Вернуть стиль
     */
    public function getStyle(): TableStyleInterface;

    /**
     * Заголовки таблицы
     *
     * @param TableCellInterface[][]|string[][][]|string[]|string[][]|TableCellInterface[] $headers
     *
     * @return $this
     */
    public function setHeaders(array $headers);

    /**
     * Возвращает строки заголовков таблицы
     *
     * @return TableCellInterface[][]
     */
    public function getHeaders(): array;

    /**
     * Устанавливает строку заголовока страницы
     *
     * @param TableCellInterface[]|string[][]|string[] $header
     *
     * @return $this
     */
    public function setHeader(int $index, array $header);

    /**
     * Возвращает строку заголовоков
     *
     * @return TableCellInterface[]|false
     */
    public function getHeader(int $index);

    /**
     * Возвращает кол-во строк заголовков
     */
    public function countHeaders(): int;

    /**
     * Проверяет наличие строки заголовка
     */
    public function hasHeader(int $index): bool;

    /**
     * Устанавливает строки
     *
     * @param TableCellInterface[][]|string[][][]|string[][] $rows
     *
     * @return $this
     */
    public function setRows(array $rows);

    /**
     * Возвращает строки
     *
     * @return TableCellInterface[][]
     */
    public function getRows(): array;

    /**
     * Добавляет строки
     *
     * @param TableCellInterface[][]|string[][][]|string[][] $rows
     *
     * @return $this
     */
    public function addRows(array $rows);

    /**
     * Добавить строку
     *
     * @param TableCellInterface[]|string[][]|string[] $row
     *
     * @return $this
     */
    public function addRow(array $row);

    /**
     * Установить строку
     *
     * @param TableCellInterface[]|string[][]|string[] $row
     *
     * @return $this
     */
    public function setRow(int $index, array $row);

    /**
     * Возвращает строку
     *
     * @return TableCellInterface[]|false
     */
    public function getRow(int $index);

    /**
     * Возвращает кол-во строк
     */
    public function countRows(): int;

    /**
     * Проверяет наличие строки
     */
    public function hasRow(int $index): bool;
}
