<?php

declare(strict_types=1);

namespace Fi1a\Unit\Console\Component\PaginationComponent;

use Fi1a\Console\Component\PaginationComponent\PaginationStyle;
use PHPUnit\Framework\TestCase;

/**
 * Стиль
 */
class PaginationStyleTest extends TestCase
{
    /**
     * Цвет
     */
    public function testColor(): void
    {
        $style = new PaginationStyle();
        $this->assertNull($style->getColor());
        $style->setColor('red');
        $this->assertEquals('red', $style->getColor());
    }

    /**
     * Цвет фона
     */
    public function testBackgroundColor(): void
    {
        $style = new PaginationStyle();
        $this->assertNull($style->getBackgroundColor());
        $style->setBackgroundColor('red');
        $this->assertEquals('red', $style->getBackgroundColor());
    }
}
