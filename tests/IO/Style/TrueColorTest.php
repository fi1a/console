<?php

declare(strict_types=1);

namespace Fi1a\Unit\Console\IO\Style;

use Fi1a\Console\IO\Style\TrueColor;
use PHPUnit\Framework\TestCase;

/**
 * TrueColor класс цвета текста и фона
 */
class TrueColorTest extends TestCase
{
    /**
     * TrueColor класс цвета текста и фона
     */
    public function testTrueColorColor()
    {
        $color = new TrueColor();
        $this->assertTrue($color->isDefault());
        $this->assertTrue(is_string($color->getColorCode()));
        $this->assertTrue(is_string($color->getBackgroundCode()));
        $color->setColor('#fff');
        $this->assertFalse($color->isDefault());
        $this->assertTrue(is_string($color->getColorCode()));
        $this->assertTrue(is_string($color->getBackgroundCode()));
        $color->setColor(TrueColor::WHITE);
        $this->assertFalse($color->isDefault());
        $this->assertTrue(is_string($color->getColorCode()));
        $this->assertTrue(is_string($color->getBackgroundCode()));
    }

    /**
     * TrueColor класс цвета текста и фона
     */
    public function testTrueColorException()
    {
        $this->expectException(\InvalidArgumentException::class);
        $color = new TrueColor();
        $color->setColor('unknown');
        $color->getColorCode();
    }
}
