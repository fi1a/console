<?php

declare(strict_types=1);

namespace Fi1a\Unit\Console\Component\TableComponent;

use Fi1a\Console\Component\TableComponent\TableCell;
use Fi1a\Console\Component\TableComponent\TableCellStyle;
use Fi1a\Console\Component\TableComponent\TableCellStyleInterface;
use PHPUnit\Framework\TestCase;

/**
 * Ячейка
 */
class TableCellTest extends TestCase
{
    /**
     * Объединение столбцов
     */
    public function testColspan(): void
    {
        $cell = new TableCell();
        $this->assertEquals(1, $cell->getColspan());
        $cell->setColspan(2);
        $this->assertEquals(2, $cell->getColspan());
    }

    /**
     * Значение
     */
    public function testValue(): void
    {
        $cell = new TableCell();
        $this->assertEquals([], $cell->getValue());
        $cell->setValue('value');
        $this->assertEquals(['value'], $cell->getValue());
    }

    /**
     * Стиль
     */
    public function testStyle(): void
    {
        $style = new TableCellStyle();
        $cell = new TableCell();
        $this->assertInstanceOf(TableCellStyleInterface::class, $cell->getStyle());
        $cell->setStyle($style);
        $this->assertEquals($style, $cell->getStyle());
    }
}
