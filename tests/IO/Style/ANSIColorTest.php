<?php

declare(strict_types=1);

namespace Fi1a\Unit\Console\IO\Style;

use Fi1a\Console\IO\Style\ANSIColor;
use PHPUnit\Framework\TestCase;

/**
 * ANSI класс цвета текста и фона
 */
class ANSIColorTest extends TestCase
{
    /**
     * ANSI класс цвета текста и фона
     */
    public function testANSIColor()
    {
        $color = new ANSIColor();
        $this->assertTrue($color->isDefault());
        $this->assertTrue(is_string($color->getColorCode()));
        $this->assertTrue(is_string($color->getBackgroundCode()));
    }

    /**
     * ANSI класс цвета текста и фона (цвет из Extended)
     */
    public function testANSIColorFromExtended()
    {
        $color = new ANSIColor('200');
        $this->assertFalse($color->isDefault());
        $this->assertTrue(is_string($color->getColorCode()));
        $this->assertTrue(is_string($color->getBackgroundCode()));
    }

    /**
     * ANSI класс цвета текста и фона (цвет из TrueColor)
     */
    public function testANSIColorFromTrueColor()
    {
        $color = new ANSIColor('#000000');
        $this->assertFalse($color->isDefault());
        $this->assertTrue(is_string($color->getColorCode()));
        $this->assertTrue(is_string($color->getBackgroundCode()));
    }

    /**
     * ANSI класс цвета текста и фона
     */
    public function testANSIColorException()
    {
        $this->expectException(\InvalidArgumentException::class);
        $color = new ANSIColor();
        $color->setColor('unknown');
    }
}
