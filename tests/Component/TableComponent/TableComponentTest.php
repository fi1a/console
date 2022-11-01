<?php

declare(strict_types=1);

namespace Fi1a\Unit\Console\Component\TableComponent;

use Fi1a\Console\Component\PanelComponent\PanelComponent;
use Fi1a\Console\Component\PanelComponent\PanelStyle;
use Fi1a\Console\Component\TableComponent\TableCell;
use Fi1a\Console\Component\TableComponent\TableCellStyle;
use Fi1a\Console\Component\TableComponent\TableComponent;
use Fi1a\Console\Component\TableComponent\TableStyle;
use Fi1a\Console\IO\ConsoleOutput;
use Fi1a\Console\IO\Formatter;
use Fi1a\Console\IO\Stream;
use Fi1a\Console\IO\Style\TrueColor;
use PHPUnit\Framework\TestCase;

/**
 * Таблица
 */
class TableComponentTest extends TestCase
{
    /**
     * Отобразить
     */
    public function testDisplay(): void
    {
        $output = new ConsoleOutput(new Formatter());
        $output->setStream(new Stream('php://memory'));
        $tableStyle = new TableStyle();
        $tableStyle->setBorderColor(TrueColor::RED);
        $cellHeaderStyle = new TableCellStyle();
        $cellStyle = new TableCellStyle();
        $cellStyle->setPadding(2);
        $table = new TableComponent($output, $tableStyle);

        $panelStyle = new PanelStyle();
        $panelStyle->setWidth(20);
        $panel = new PanelComponent(
            $output,
            'Lorem Ipsum Dolor Sit Amet Lorem Ipsum Dolor Sit Amet',
            $panelStyle
        );

        $table->setHeaders([
            [
                [
                    'value' => ['Header column 1', $panel],
                    'style' => $cellHeaderStyle,
                ],
                'Header column 2',
                new TableCell(['value' => 'Header column 3']),
            ],
        ]);
        $table->setRows([
            [
                'Row 1 column 1', 'Row 1 column 2', 'Row 1 column 3', 'Row 2 column 4',
            ],
            [
                'Row 2 column 1',
                new TableCell([
                    'value' => 'Row 2 column 2',
                    'colspan' => 2,
                    'style' => $cellStyle,
                ]),
                'Row 2 column 4',
            ],
            [
                'Row 3 column 1',
                new TableCell([
                    'value' => 'Row 3 column 2',
                    'colspan' => 3,
                    'style' => $cellStyle,
                ]),
            ],
        ]);

        $this->assertTrue($table->display());
    }

    /**
     * Отобразить
     */
    public function testDisplayTableWidth(): void
    {
        $output = new ConsoleOutput(new Formatter());
        $output->setStream(new Stream('php://memory'));
        $tableStyle = new TableStyle();
        $tableStyle->setWidth(1);
        $cellHeaderStyle = new TableCellStyle();
        $cellStyle = new TableCellStyle();
        $cellStyle->setWidth(20);
        $table = new TableComponent($output, $tableStyle);

        $style = new PanelStyle();
        $style->setWidth(20);
        $panel = new PanelComponent(
            $output,
            'Lorem Ipsum Dolor Sit Amet Lorem Ipsum Dolor Sit Amet',
            $style
        );

        $table->setHeaders([
            [
                [
                    'value' => ['Header column 1', $panel],
                    'style' => $cellHeaderStyle,
                ],
                'Header column 2',
                new TableCell(['value' => 'Header column 3']),
            ],
        ]);
        $table->setRows([
            [
                'Row 1 column 1', 'Row 1 column 2', 'Row 1 column 3',
            ],
            [
                'Row 2 column 1',
                new TableCell([
                    'value' => 'Row 2 column 2',
                    'style' => $cellStyle,
                ]),
                [
                    'value' => 'Row 2 column 3',
                    'colspan' => 2,
                ],
            ],
        ]);

        $this->assertTrue($table->display());

        $tableStyle->setWidth(120);
        $this->assertTrue($table->display());
    }

    /**
     * Методы работы с шапкой
     */
    public function testHeaders(): void
    {
        $output = new ConsoleOutput(new Formatter());
        $output->setStream(new Stream('php://memory'));
        $tableStyle = new TableStyle();
        $table = new TableComponent($output, $tableStyle);
        $table->setHeaders([
            'Header column 1',
            'Header column 2',
            'Header column 3',
        ]);
        $this->assertCount(3, $table->getHeader(0));
        $this->assertFalse($table->getHeader(1));
        $this->assertEquals(1, $table->countHeaders());
        $this->assertTrue($table->display());
    }

    /**
     * Методы работы со строками
     */
    public function testRows(): void
    {
        $output = new ConsoleOutput(new Formatter());
        $output->setStream(new Stream('php://memory'));
        $tableStyle = new TableStyle();
        $table = new TableComponent($output, $tableStyle);
        $table->setRows([
            [
                'Row 1 column 1',
                'Row 1 column 2',
                'Row 1 column 3',
            ],
        ]);
        $this->assertCount(3, $table->getRow(0));
        $this->assertFalse($table->getRow(1));
        $this->assertEquals(1, $table->countRows());
        $this->assertTrue($table->display());
    }

    /**
     * Отобразить (ASCII границы)
     */
    public function testDisplayASCII(): void
    {
        $output = new ConsoleOutput(new Formatter());
        $output->setStream(new Stream('php://memory'));
        $tableStyle = new TableStyle();
        $tableStyle->setBorder('ascii');
        $table = new TableComponent($output, $tableStyle);

        $table->setHeaders([
            [
                'Header column 1',
                'Header column 2',
                'Header column 3',
            ],
        ]);
        $table->setRows([
            [
                'Row 1 column 1', 'Row 1 column 2', 'Row 1 column 3', 'Row 2 column 4',
            ],
            [
                'Row 2 column 1',
                new TableCell([
                    'value' => 'Row 2 column 2',
                    'colspan' => 2,
                ]),
                'Row 2 column 4',
            ],
            [
                'Row 3 column 1',
                new TableCell([
                    'value' => 'Row 3 column 2',
                    'colspan' => 3,
                ]),
            ],
        ]);

        $this->assertTrue($table->display());

        $table->setRows([]);
        $this->assertTrue($table->display());
    }

    /**
     * Отобразить (Double границы)
     */
    public function testDisplayDouble(): void
    {
        $output = new ConsoleOutput(new Formatter());
        $output->setStream(new Stream('php://memory'));
        $tableStyle = new TableStyle();
        $tableStyle->setBorder('double');
        $table = new TableComponent($output, $tableStyle);

        $table->setHeaders([
            [
                'Header column 1',
                'Header column 2',
                'Header column 3',
            ],
        ]);
        $table->setRows([
            [
                'Row 1 column 1', 'Row 1 column 2', 'Row 1 column 3', 'Row 2 column 4',
            ],
            [
                'Row 2 column 1',
                new TableCell([
                    'value' => 'Row 2 column 2',
                    'colspan' => 2,
                ]),
                'Row 2 column 4',
            ],
            [
                'Row 3 column 1',
                new TableCell([
                    'value' => 'Row 3 column 2',
                    'colspan' => 3,
                ]),
            ],
        ]);

        $this->assertTrue($table->display());

        $table->setRows([]);
        $this->assertTrue($table->display());
    }

    /**
     * Отобразить (Double compact границы)
     */
    public function testDisplayDoubleCompact(): void
    {
        $output = new ConsoleOutput(new Formatter());
        $output->setStream(new Stream('php://memory'));
        $tableStyle = new TableStyle();
        $tableStyle->setBorder('double_compact');
        $table = new TableComponent($output, $tableStyle);

        $table->setHeaders([
            [
                'Header column 1',
                'Header column 2',
                'Header column 3',
            ],
        ]);
        $table->setRows([
            [
                'Row 1 column 1', 'Row 1 column 2', 'Row 1 column 3', 'Row 2 column 4',
            ],
            [
                'Row 2 column 1',
                new TableCell([
                    'value' => 'Row 2 column 2',
                    'colspan' => 2,
                ]),
                'Row 2 column 4',
            ],
            [
                'Row 3 column 1',
                new TableCell([
                    'value' => 'Row 3 column 2',
                    'colspan' => 3,
                ]),
            ],
        ]);

        $this->assertTrue($table->display());

        $table->setRows([]);
        $this->assertTrue($table->display());
    }

    /**
     * Отобразить (Heavy границы)
     */
    public function testDisplayHeavy(): void
    {
        $output = new ConsoleOutput(new Formatter());
        $output->setStream(new Stream('php://memory'));
        $tableStyle = new TableStyle();
        $tableStyle->setBorder('heavy');
        $table = new TableComponent($output, $tableStyle);

        $table->setHeaders([
            [
                'Header column 1',
                'Header column 2',
                'Header column 3',
            ],
        ]);
        $table->setRows([
            [
                'Row 1 column 1', 'Row 1 column 2', 'Row 1 column 3', 'Row 2 column 4',
            ],
            [
                'Row 2 column 1',
                new TableCell([
                    'value' => 'Row 2 column 2',
                    'colspan' => 2,
                ]),
                'Row 2 column 4',
            ],
            [
                'Row 3 column 1',
                new TableCell([
                    'value' => 'Row 3 column 2',
                    'colspan' => 3,
                ]),
            ],
        ]);

        $this->assertTrue($table->display());

        $table->setRows([]);
        $this->assertTrue($table->display());
    }

    /**
     * Отобразить (Heavy compact границы)
     */
    public function testDisplayHeavyCompact(): void
    {
        $output = new ConsoleOutput(new Formatter());
        $output->setStream(new Stream('php://memory'));
        $tableStyle = new TableStyle();
        $tableStyle->setBorder('heavy_compact');
        $table = new TableComponent($output, $tableStyle);

        $table->setHeaders([
            [
                'Header column 1',
                'Header column 2',
                'Header column 3',
            ],
        ]);
        $table->setRows([
            [
                'Row 1 column 1', 'Row 1 column 2', 'Row 1 column 3', 'Row 2 column 4',
            ],
            [
                'Row 2 column 1',
                new TableCell([
                    'value' => 'Row 2 column 2',
                    'colspan' => 2,
                ]),
                'Row 2 column 4',
            ],
            [
                'Row 3 column 1',
                new TableCell([
                    'value' => 'Row 3 column 2',
                    'colspan' => 3,
                ]),
            ],
        ]);

        $this->assertTrue($table->display());

        $table->setRows([]);
        $this->assertTrue($table->display());
    }

    /**
     * Отобразить (Double compact границы)
     */
    public function testDisplayNone(): void
    {
        $output = new ConsoleOutput(new Formatter());
        $output->setStream(new Stream('php://memory'));
        $tableStyle = new TableStyle();
        $tableStyle->setBorder('none');
        $table = new TableComponent($output, $tableStyle);

        $table->setHeaders([
            [
                'Header column 1',
                'Header column 2',
                'Header column 3',
            ],
        ]);
        $table->setRows([
            [
                'Row 1 column 1', 'Row 1 column 2', 'Row 1 column 3', 'Row 2 column 4',
            ],
            [
                'Row 2 column 1',
                new TableCell([
                    'value' => 'Row 2 column 2',
                    'colspan' => 2,
                ]),
                'Row 2 column 4',
            ],
            [
                'Row 3 column 1',
                new TableCell([
                    'value' => 'Row 3 column 2',
                    'colspan' => 3,
                ]),
            ],
        ]);

        $this->assertTrue($table->display());

        $table->setRows([]);
        $this->assertTrue($table->display());
    }
}
