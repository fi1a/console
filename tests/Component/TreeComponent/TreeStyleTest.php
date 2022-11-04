<?php

declare(strict_types=1);

namespace Fi1a\Unit\Console\Component\TreeComponent;

use Fi1a\Console\Component\TreeComponent\TreeStyle;
use Fi1a\Console\IO\Style\TrueColor;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * Стиль
 */
class TreeStyleTest extends TestCase
{
    /**
     * Цвет линии
     */
    public function testLineColor(): void
    {
        $style = new TreeStyle();
        $this->assertNull($style->getLineColor());
        $style->setLineColor(TrueColor::GREEN);
        $this->assertEquals(TrueColor::GREEN, $style->getLineColor());
    }

    /**
     * Тип линии
     */
    public function testLineType(): void
    {
        $style = new TreeStyle();
        $this->assertEquals('normal', $style->getLine());
        $style->setLine('ascii');
        $this->assertEquals('ascii', $style->getLine());
    }

    /**
     * Тип линии (исключение)
     */
    public function testLineTypeException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $style = new TreeStyle();
        $style->setLine('unknown');
    }
}
