<?php

declare(strict_types=1);

namespace Fi1a\Unit\Console\IO\Style;

use Fi1a\Console\IO\Style\ExtendedColor;
use PHPUnit\Framework\TestCase;

/**
 * Расширенный класс цвета текста и фона
 */
class ExtendedColorTest extends TestCase
{
    /**
     * Расширенный класс цвета текста и фона
     */
    public function testExtendedColor()
    {
        $color = new ExtendedColor();
        $this->assertTrue($color->isDefault());
        $this->assertTrue(is_string($color->getColorCode()));
        $this->assertTrue(is_string($color->getBackgroundCode()));
        $color->setColor('100');
        $this->assertFalse($color->isDefault());
        $this->assertTrue(is_string($color->getColorCode()));
        $this->assertTrue(is_string($color->getBackgroundCode()));
    }

    /**
     * Расширенный класс цвета текста и фона
     */
    public function testExtendedColorException()
    {
        $this->expectException(\InvalidArgumentException::class);
        $color = new ExtendedColor();
        $color->setColor('unknown');
    }

    /**
     * Расширенный класс цвета текста и фона
     */
    public function testExtendedColorExceptionSetColor()
    {
        $this->expectException(\InvalidArgumentException::class);
        $color = new ExtendedColor();
        $color->setColor('300');
    }
}
