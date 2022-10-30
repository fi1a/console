<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\TableComponent;

use Fi1a\Collection\DataType\IValueObject;
use Fi1a\Console\Component\ComponentInterface;

/**
 * Интерфейс ячейки
 */
interface TableCellInterface extends IValueObject
{
    /**
     * Устанавливает объединение столбцов
     *
     * @return $this
     */
    public function setColspan(?int $colspan);

    /**
     * Возвращает объединение столбцов
     */
    public function getColspan(): int;

    /**
     * Устанавливает значение
     *
     * @param string[]|ComponentInterface[]|string|ComponentInterface|null $value
     *
     * @return $this
     */
    public function setValue($value);

    /**
     * Возвращает значение
     *
     * @return string[]|ComponentInterface[]
     */
    public function getValue();

    /**
     * Установить стиль
     *
     * @return $this
     */
    public function setStyle(?TableCellStyleInterface $style);

    /**
     * Возвращает стиль
     */
    public function getStyle(): TableCellStyleInterface;
}
