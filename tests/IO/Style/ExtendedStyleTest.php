<?php

declare(strict_types=1);

namespace Fi1a\Unit\Console\IO\Style;

use Fi1a\Console\IO\Style\Blink;
use Fi1a\Console\IO\Style\Bold;
use Fi1a\Console\IO\Style\Conceal;
use Fi1a\Console\IO\Style\ExtendedColor;
use Fi1a\Console\IO\Style\ExtendedStyle;
use Fi1a\Console\IO\Style\Reverse;
use Fi1a\Console\IO\Style\Underscore;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * Расширенный стиль для консольного вывода
 */
class ExtendedStyleTest extends TestCase
{
    /**
     * Форматирование
     */
    public function testExtendedStyle()
    {
        $style = new ExtendedStyle();
        $this->assertTrue(is_string($style->apply('text')));

        $style = new ExtendedStyle(ExtendedColor::BLACK, ExtendedColor::WHITE, [Bold::NAME,]);
        $this->assertTrue(is_string($style->apply('text')));

        $style = new ExtendedStyle(ExtendedColor::BLACK, ExtendedColor::WHITE, [Underscore::NAME,]);
        $this->assertTrue(is_string($style->apply('text')));

        $style = new ExtendedStyle(ExtendedColor::BLACK, ExtendedColor::WHITE, [Blink::NAME,]);
        $this->assertTrue(is_string($style->apply('text')));

        $style = new ExtendedStyle(ExtendedColor::BLACK, ExtendedColor::WHITE, [Conceal::NAME,]);
        $this->assertTrue(is_string($style->apply('text')));

        $style = new ExtendedStyle(ExtendedColor::BLACK, ExtendedColor::WHITE, [Reverse::NAME,]);
        $this->assertTrue(is_string($style->apply('text')));

        $style = new ExtendedStyle(ExtendedColor::BLACK, ExtendedColor::WHITE, [Bold::NAME, Reverse::NAME,]);
        $this->assertTrue($style->unsetOption(Reverse::NAME));
        $this->assertFalse($style->unsetOption(Reverse::NAME));
        $this->assertTrue(is_string($style->apply('text')));
    }

    /**
     * Форматирование
     */
    public function testExtendedStyleException()
    {
        $this->expectException(InvalidArgumentException::class);
        $style = new ExtendedStyle(ExtendedColor::BLACK, ExtendedColor::WHITE, ['unknown']);
        $this->assertTrue(is_string($style->apply('text')));
    }
}
