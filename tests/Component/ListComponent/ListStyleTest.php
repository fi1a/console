<?php

declare(strict_types=1);

namespace Fi1a\Unit\Console\Component\ListComponent;

use Fi1a\Console\Component\ListComponent\ListStyle;
use Fi1a\Console\Component\ListComponent\ListStyleInterface;
use Fi1a\Console\IO\Style\TrueColor;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * Стиль
 */
class ListStyleTest extends TestCase
{
    /**
     * Конструктор
     */
    public function testConstructor(): void
    {
        $style = new ListStyle(ListStyle::POSITION_OUTSIDE, 'lower-alpha', 10);
        $this->assertEquals(ListStyle::POSITION_OUTSIDE, $style->getPosition());
        $this->assertEquals('lower-alpha', $style->getType());
        $this->assertEquals(10, $style->getWidth());
    }

    /**
     * Местоположение маркера списка
     */
    public function testPosition(): void
    {
        $style = new ListStyle();
        $this->assertEquals(ListStyleInterface::POSITION_OUTSIDE, $style->getPosition());
        $style->setPosition(ListStyleInterface::POSITION_INSIDE);
        $this->assertEquals(ListStyleInterface::POSITION_INSIDE, $style->getPosition());
        $this->assertGreaterThan(0, $style->getWidth());
    }

    /**
     * Местоположение маркера списка (исключение)
     */
    public function testPositionException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $style = new ListStyle();
        $style->setPosition('unknown');
    }

    /**
     * Тип маркера списка
     */
    public function testType(): void
    {
        $style = new ListStyle();
        $this->assertEquals('disc', $style->getType());
        $style->setType('lower-alpha');
        $this->assertEquals('lower-alpha', $style->getType());
    }

    /**
     * Тип маркера списка (исключение)
     */
    public function testTypeException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $style = new ListStyle();
        $style->setType('unknown');
    }

    /**
     * Установить цвет маркера
     */
    public function testMarkerColor(): void
    {
        $style = new ListStyle();
        $this->assertNull($style->getMarkerColor());
        $style->setMarkerColor(TrueColor::GREEN);
        $this->assertEquals(TrueColor::GREEN, $style->getMarkerColor());
    }

    /**
     * Отступ между элементами списка
     */
    public function testMarginItem(): void
    {
        $style = new ListStyle();
        $this->assertNull($style->getMarginItem());
        $style->setMarginItem(1);
        $this->assertEquals(1, $style->getMarginItem());
    }

    /**
     * Отступ между элементами списка (исключение)
     */
    public function testMarginItemException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $style = new ListStyle();
        $style->setMarginItem(-1);
    }
}
