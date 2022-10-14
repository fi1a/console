<?php

declare(strict_types=1);

namespace Fi1a\Unit\Console\IO\Style;

use Fi1a\Console\IO\Style\Blink;
use Fi1a\Console\IO\Style\Bold;
use Fi1a\Console\IO\Style\Conceal;
use Fi1a\Console\IO\Style\Reverse;
use Fi1a\Console\IO\Style\TrueColor;
use Fi1a\Console\IO\Style\TrueColorStyle;
use Fi1a\Console\IO\Style\Underscore;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * TrueColor стиль для консольного вывода
 */
class TrueColorStyleTest extends TestCase
{
    /**
     * Форматирование
     */
    public function testTrueColorStyle()
    {
        $style = new TrueColorStyle();
        $this->assertTrue(is_string($style->apply('text')));

        $style = new TrueColorStyle(TrueColor::BLACK, TrueColor::WHITE, [Bold::NAME,]);
        $this->assertTrue(is_string($style->apply('text')));

        $style = new TrueColorStyle(TrueColor::BLACK, TrueColor::WHITE, [Underscore::NAME,]);
        $this->assertTrue(is_string($style->apply('text')));

        $style = new TrueColorStyle(TrueColor::BLACK, TrueColor::WHITE, [Blink::NAME,]);
        $this->assertTrue(is_string($style->apply('text')));

        $style = new TrueColorStyle(TrueColor::BLACK, TrueColor::WHITE, [Conceal::NAME,]);
        $this->assertTrue(is_string($style->apply('text')));

        $style = new TrueColorStyle(TrueColor::BLACK, TrueColor::WHITE, [Reverse::NAME,]);
        $this->assertTrue(is_string($style->apply('text')));

        $style = new TrueColorStyle(TrueColor::BLACK, TrueColor::WHITE, [Bold::NAME, Reverse::NAME,]);
        $this->assertTrue($style->unsetOption(Reverse::NAME));
        $this->assertFalse($style->unsetOption(Reverse::NAME));
        $this->assertTrue(is_string($style->apply('text')));
    }

    /**
     * Форматирование
     */
    public function testTrueColorStyleException()
    {
        $this->expectException(InvalidArgumentException::class);
        $style = new TrueColorStyle(TrueColor::BLACK, TrueColor::WHITE, ['unknown']);
        $this->assertTrue(is_string($style->apply('text')));
    }
}
