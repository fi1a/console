<?php

declare(strict_types=1);

namespace Fi1a\Unit\Console\Component;

use Fi1a\Console\Component\Rectangle;
use Fi1a\Console\Component\RectangleInterface;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * Размер отображаемой области и выравнивание
 */
class RectangleTest extends TestCase
{
    /**
     * Ширина
     */
    public function testWidth(): void
    {
        $box = new Rectangle();
        $this->assertNull($box->getWidth());
        $box->setWidth(100);
        $this->assertEquals(100, $box->getWidth());
        $box = new Rectangle(100);
        $this->assertEquals(100, $box->getWidth());
    }

    /**
     * Исключение при нуле или отрицательном значении
     */
    public function testWidthException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $box = new Rectangle();
        $box->setWidth(0);
    }

    /**
     * Высота
     */
    public function testHeight(): void
    {
        $box = new Rectangle();
        $this->assertNull($box->getHeight());
        $box->setHeight(100);
        $this->assertEquals(100, $box->getHeight());
        $box = new Rectangle(100, 100);
        $this->assertEquals(100, $box->getHeight());
    }

    /**
     * Исключение при нуле или отрицательном значении
     */
    public function testHeightException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $box = new Rectangle();
        $box->setHeight(0);
    }

    /**
     * Позиция слева
     */
    public function testLeft(): void
    {
        $box = new Rectangle();
        $this->assertNull($box->getLeft());
        $box->setLeft(100);
        $this->assertEquals(100, $box->getLeft());
        $box = new Rectangle(100, 100, 100);
        $this->assertEquals(100, $box->getLeft());
    }

    /**
     * Исключение при нуле или отрицательном значении
     */
    public function testLeftException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $box = new Rectangle();
        $box->setLeft(0);
    }

    /**
     * Позиция сверху
     */
    public function testTop(): void
    {
        $box = new Rectangle();
        $this->assertNull($box->getTop());
        $box->setTop(100);
        $this->assertEquals(100, $box->getTop());
        $box = new Rectangle(100, 100, 100, 100);
        $this->assertEquals(100, $box->getTop());
    }

    /**
     * Исключение при нуле или отрицательном значении
     */
    public function testTopException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $box = new Rectangle();
        $box->setTop(0);
    }

    /**
     * Выравнивание
     */
    public function testAlign(): void
    {
        $box = new Rectangle();
        $this->assertNull($box->getAlign());
        $box->setAlign(RectangleInterface::ALIGN_LEFT);
        $this->assertEquals(RectangleInterface::ALIGN_LEFT, $box->getAlign());
        $box = new Rectangle(100, 100, 100, 100, RectangleInterface::ALIGN_LEFT);
        $this->assertEquals(RectangleInterface::ALIGN_LEFT, $box->getAlign());
    }

    /**
     * Выравнивание
     */
    public function testAlignException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $box = new Rectangle();
        $box->setAlign('unknown');
    }
}
