<?php

declare(strict_types=1);

namespace Fi1a\Unit\Console\Component\PanelComponent;

use Fi1a\Console\Component\PanelComponent\PanelStyle;
use PHPUnit\Framework\TestCase;

/**
 * Стиль
 */
class PanelStyleTest extends TestCase
{
    /**
     * Границы
     */
    public function testBorder(): void
    {
        $style = new PanelStyle();
        $this->assertEquals($style::BORDER_NONE, $style->getBorder());
        $style->setBorder($style::BORDER_ASCII);
        $this->assertEquals($style::BORDER_ASCII, $style->getBorder());
    }

    /**
     * Границы
     */
    public function testBorderException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $style = new PanelStyle();
        $style->setBorder('unknown');
    }

    /**
     * Отступы
     */
    public function testPadding(): void
    {
        $style = new PanelStyle();
        $this->assertNull($style->getPaddingLeft());
        $this->assertNull($style->getPaddingTop());
        $this->assertNull($style->getPaddingRight());
        $this->assertNull($style->getPaddingBottom());
        $style->setPadding(2);
        $this->assertEquals(6, $style->getPaddingLeft());
        $this->assertEquals(2, $style->getPaddingTop());
        $this->assertEquals(6, $style->getPaddingRight());
        $this->assertEquals(2, $style->getPaddingBottom());
    }

    /**
     * Цвет границ
     */
    public function testBorderColor(): void
    {
        $style = new PanelStyle();
        $this->assertNull($style->getLeftBorderColor());
        $this->assertNull($style->getTopBorderColor());
        $this->assertNull($style->getRightBorderColor());
        $this->assertNull($style->getBottomBorderColor());
        $style->setBorderColor('red');
        $this->assertEquals('red', $style->getLeftBorderColor());
        $this->assertEquals('red', $style->getTopBorderColor());
        $this->assertEquals('red', $style->getRightBorderColor());
        $this->assertEquals('red', $style->getBottomBorderColor());
    }

    /**
     * Цвет
     */
    public function testColor(): void
    {
        $style = new PanelStyle();
        $this->assertNull($style->getColor());
        $style->setColor('red');
        $this->assertEquals('red', $style->getColor());
    }

    /**
     * Цвет фона
     */
    public function testBackgroundColor(): void
    {
        $style = new PanelStyle();
        $this->assertNull($style->getBackgroundColor());
        $style->setBackgroundColor('red');
        $this->assertEquals('red', $style->getBackgroundColor());
    }
}
