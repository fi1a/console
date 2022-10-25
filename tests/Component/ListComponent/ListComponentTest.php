<?php

declare(strict_types=1);

namespace Fi1a\Unit\Console\Component\ListComponent;

use Fi1a\Console\Component\ListComponent\ListComponent;
use Fi1a\Console\Component\ListComponent\ListStyle;
use Fi1a\Console\Component\Rectangle;
use Fi1a\Console\IO\ConsoleOutput;
use Fi1a\Console\IO\Formatter;
use Fi1a\Console\IO\Stream;
use PHPUnit\Framework\TestCase;

/**
 * Список
 */
class ListComponentTest extends TestCase
{
    /**
     * Отображение
     */
    public function testDisplay(): void
    {
        $output = new ConsoleOutput(new Formatter());
        $output->setStream(new Stream('php://memory'));
        $style = new ListStyle();
        $style->setMarginItem(1);
        $list = new ListComponent($output, $style, []);

        $subSubStyle = new ListStyle();
        $subSubStyle->setPosition($subSubStyle::POSITION_OUTSIDE);
        $subSubList = new ListComponent($output, $subSubStyle, ['Lorem', 'Ipsum']);

        $subStyle = new ListStyle();
        $subStyle->setType($subStyle::TYPE_NONE);
        $subList = new ListComponent($output, $subStyle, [$subSubList, 'Lorem', 'Ipsum']);

        $list->addItem('Lorem');
        $list->addItem(['Lorem', $subList, 'ipsum']);
        $list->addItem('Lorem');

        $this->assertTrue($list->display());
    }

    /**
     * Отображение
     */
    public function testDisplayEmpty(): void
    {
        $output = new ConsoleOutput(new Formatter());
        $output->setStream(new Stream('php://memory'));
        $style = new ListStyle();
        $list = new ListComponent($output, $style, []);
        $this->assertTrue($list->display());
    }

    /**
     * Отображение
     */
    public function testGetSymbolsEmpty(): void
    {
        $output = new ConsoleOutput(new Formatter());
        $output->setStream(new Stream('php://memory'));
        $style = new ListStyle();
        $list = new ListComponent($output, $style, []);
        $rectangle = new Rectangle(
            20
        );
        $this->assertCount(0, $list->getSymbols($rectangle));
    }

    /**
     * Отображение (Тип: A, B, C, D, E, …)
     */
    public function testDisplayTypeUpperAlpha(): void
    {
        $output = new ConsoleOutput(new Formatter());
        $output->setStream(new Stream('php://memory'));
        $style = new ListStyle();
        $style->setType($style::TYPE_UPPER_ALPHA);
        $list = new ListComponent($output, $style, []);
        $list->addItem('Lorem');
        $list->addItem('Ipsum');
        $this->assertTrue($list->display());
    }

    /**
     * Отображение (Тип: В качестве маркера выступает закрашенный квадрат.)
     */
    public function testDisplayTypeSquare(): void
    {
        $output = new ConsoleOutput(new Formatter());
        $output->setStream(new Stream('php://memory'));
        $style = new ListStyle();
        $style->setType($style::TYPE_SQUARE);
        $list = new ListComponent($output, $style, []);
        $list->addItem('Lorem');
        $list->addItem('Ipsum');
        $this->assertTrue($list->display());
    }

    /**
     * Отображение (Тип: a, b, c, d, e, …)
     */
    public function testDisplayTypeLoweAlpha(): void
    {
        $output = new ConsoleOutput(new Formatter());
        $output->setStream(new Stream('php://memory'));
        $style = new ListStyle();
        $style->setType($style::TYPE_LOWER_ALPHA);
        $list = new ListComponent($output, $style, []);
        for ($index = 0; $index < 50; $index++) {
            $list->addItem('Lorem ' . $index);
        }
        $this->assertTrue($list->display());
    }

    /**
     * Отображение (Тип: 01, 02, 03, 04, 05, …)
     */
    public function testDisplayTypeDecimalLeadingZero(): void
    {
        $output = new ConsoleOutput(new Formatter());
        $output->setStream(new Stream('php://memory'));
        $style = new ListStyle();
        $style->setType($style::TYPE_DECIMAL_LEADING_ZERO);
        $list = new ListComponent($output, $style, []);
        $list->addItem('Lorem');
        $list->addItem('Ipsum');
        $this->assertTrue($list->display());
    }

    /**
     * Отображение (Тип: 1, 2, 3, 4, 5, …)
     */
    public function testDisplayTypeDecimal(): void
    {
        $output = new ConsoleOutput(new Formatter());
        $output->setStream(new Stream('php://memory'));
        $style = new ListStyle();
        $style->setType($style::TYPE_DECIMAL);
        $list = new ListComponent($output, $style, []);
        $list->addItem('Lorem');
        $list->addItem('Ipsum');
        $this->assertTrue($list->display());
    }

    /**
     * Отображение (Тип: В качестве маркера выступает незакрашенный кружок.)
     */
    public function testDisplayTypeCircle(): void
    {
        $output = new ConsoleOutput(new Formatter());
        $output->setStream(new Stream('php://memory'));
        $style = new ListStyle();
        $style->setType($style::TYPE_CIRCLE);
        $list = new ListComponent($output, $style, []);
        $list->addItem('Lorem');
        $list->addItem('Ipsum');
        $this->assertTrue($list->display());
    }
}
