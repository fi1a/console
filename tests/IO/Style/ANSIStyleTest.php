<?php

declare(strict_types=1);

namespace Fi1a\Unit\Console\IO\Style;

use Fi1a\Console\IO\Style\ANSIColor;
use Fi1a\Console\IO\Style\ANSIStyle;
use Fi1a\Console\IO\Style\Blink;
use Fi1a\Console\IO\Style\Bold;
use Fi1a\Console\IO\Style\Conceal;
use Fi1a\Console\IO\Style\Reverse;
use Fi1a\Console\IO\Style\Underscore;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * ANSI стиль для консольного вывода
 */
class ANSIStyleTest extends TestCase
{
    /**
     * Форматирование
     */
    public function testANSIStyle()
    {
        $style = new ANSIStyle();
        $this->assertTrue(is_string($style->apply('text')));

        $style = new ANSIStyle(ANSIColor::BLACK, ANSIColor::WHITE, [Bold::NAME,]);
        $this->assertTrue(is_string($style->apply('text')));

        $style = new ANSIStyle(ANSIColor::BLACK, ANSIColor::WHITE, [Underscore::NAME,]);
        $this->assertTrue(is_string($style->apply('text')));

        $style = new ANSIStyle(ANSIColor::BLACK, ANSIColor::WHITE, [Blink::NAME,]);
        $this->assertTrue(is_string($style->apply('text')));

        $style = new ANSIStyle(ANSIColor::BLACK, ANSIColor::WHITE, [Conceal::NAME,]);
        $this->assertTrue(is_string($style->apply('text')));

        $style = new ANSIStyle(ANSIColor::BLACK, ANSIColor::WHITE, [Reverse::NAME,]);
        $this->assertTrue(is_string($style->apply('text')));

        $style = new ANSIStyle(ANSIColor::BLACK, ANSIColor::WHITE, [Bold::NAME, Reverse::NAME,]);
        $this->assertTrue($style->unsetOption(Reverse::NAME));
        $this->assertFalse($style->unsetOption(Reverse::NAME));
        $this->assertTrue(is_string($style->apply('text')));
    }

    /**
     * Форматирование
     */
    public function testANSIStyleException()
    {
        $this->expectException(InvalidArgumentException::class);
        $style = new ANSIStyle(ANSIColor::BLACK, ANSIColor::WHITE, ['unknown']);
        $this->assertTrue(is_string($style->apply('text')));
    }
}
