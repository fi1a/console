<?php

declare(strict_types=1);

namespace Fi1a\Unit\Console\Component\PanelComponent;

use Fi1a\Console\Component\GroupComponent\GroupStyle;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * Стиль
 */
class GroupStyleTest extends TestCase
{
    /**
     * Стиль
     */
    public function testStyle(): void
    {
        $style = new GroupStyle(100, 1);
        $this->assertEquals(100, $style->getWidth());
        $this->assertEquals(1, $style->getPanelSpacing());
    }

    /**
     * Стиль
     */
    public function testWidthException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new GroupStyle(-1);
    }
}
