<?php

declare(strict_types=1);

namespace Fi1a\Unit\Console\Component\TableComponent;

use Fi1a\Console\Component\TableComponent\TableCellStyle;
use Fi1a\Console\Component\TableComponent\TableCellStyleInterface;
use PHPUnit\Framework\TestCase;

/**
 * Стиль ячейки
 */
class TableCellStyleTest extends TestCase
{
    /**
     * Конструктор
     */
    public function testConstruct(): void
    {
        $style = new TableCellStyle(10, TableCellStyleInterface::ALIGN_CENTER);
        $this->assertEquals(10, $style->getWidth());
        $this->assertEquals(TableCellStyleInterface::ALIGN_CENTER, $style->getAlign());
    }
}
