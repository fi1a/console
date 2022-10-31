<?php

declare(strict_types=1);

namespace Fi1a\Unit\Console\Component\TableComponent;

use Fi1a\Console\Component\TableComponent\TableStyle;
use PHPUnit\Framework\TestCase;

/**
 * Стиль таблицы
 */
class TableStyleTest extends TestCase
{
    /**
     * Конструктор
     */
    public function testConstruct(): void
    {
        $style = new TableStyle(10, 'ascii');
        $this->assertEquals(10, $style->getWidth());
        $this->assertEquals('ascii', $style->getBorder());
    }

    /**
     * Границы
     */
    public function testBorder(): void
    {
        $style = new TableStyle();
        $this->assertEquals('ascii_compact', $style->getBorder());
        $style->setBorder('ascii');
        $this->assertEquals('ascii', $style->getBorder());
    }

    /**
     * Границы
     */
    public function testBorderException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $style = new TableStyle();
        $style->setBorder('unknown');
    }

    /**
     * Отступы
     */
    public function testPadding(): void
    {
        $style = new TableStyle();
        $this->assertEquals(3, $style->getPaddingLeft());
        $this->assertEquals(1, $style->getPaddingTop());
        $this->assertEquals(3, $style->getPaddingRight());
        $this->assertEquals(1, $style->getPaddingBottom());
        $style->setPadding(2);
        $this->assertEquals(6, $style->getPaddingLeft());
        $this->assertEquals(2, $style->getPaddingTop());
        $this->assertEquals(6, $style->getPaddingRight());
        $this->assertEquals(2, $style->getPaddingBottom());
    }

    /**
     * Цвет
     */
    public function testColor(): void
    {
        $style = new TableStyle();
        $this->assertNull($style->getColor());
        $style->setColor('red');
        $this->assertEquals('red', $style->getColor());
    }

    /**
     * Цвет фона
     */
    public function testBackgroundColor(): void
    {
        $style = new TableStyle();
        $this->assertNull($style->getBackgroundColor());
        $style->setBackgroundColor('red');
        $this->assertEquals('red', $style->getBackgroundColor());
    }

    /**
     * Цвет границ
     */
    public function testBorderColor(): void
    {
        $style = new TableStyle();
        $this->assertNull($style->getBorderColor());
        $style->setBorderColor('red');
        $this->assertEquals('red', $style->getBorderColor());
    }

    /**
     * Цвет шапки
     */
    public function testHeaderColor(): void
    {
        $style = new TableStyle();
        $this->assertEquals('green', $style->getHeaderColor());
        $style->setHeaderColor('red');
        $this->assertEquals('red', $style->getHeaderColor());
    }

    /**
     * Цвет фона шапки
     */
    public function testHeaderBackgroundColor(): void
    {
        $style = new TableStyle();
        $this->assertNull($style->getHeaderBackgroundColor());
        $style->setHeaderBackgroundColor('red');
        $this->assertEquals('red', $style->getHeaderBackgroundColor());
    }
}
