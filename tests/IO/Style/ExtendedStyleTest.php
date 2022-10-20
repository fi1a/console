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

        $style = new ExtendedStyle(ExtendedColor::BLACK, ExtendedColor::WHITE, [Bold::getName(),]);
        $this->assertTrue(is_string($style->apply('text')));

        $style = new ExtendedStyle(ExtendedColor::BLACK, ExtendedColor::WHITE, [Underscore::getName(),]);
        $this->assertTrue(is_string($style->apply('text')));

        $style = new ExtendedStyle(ExtendedColor::BLACK, ExtendedColor::WHITE, [Blink::getName(),]);
        $this->assertTrue(is_string($style->apply('text')));

        $style = new ExtendedStyle(ExtendedColor::BLACK, ExtendedColor::WHITE, [Conceal::getName(),]);
        $this->assertTrue(is_string($style->apply('text')));

        $style = new ExtendedStyle(ExtendedColor::BLACK, ExtendedColor::WHITE, [Reverse::getName(),]);
        $this->assertTrue(is_string($style->apply('text')));

        $style = new ExtendedStyle(
            ExtendedColor::BLACK,
            ExtendedColor::WHITE,
            [Bold::getName(), Reverse::getName(),]
        );
        $this->assertTrue($style->unsetOption(Reverse::getName()));
        $this->assertFalse($style->unsetOption(Reverse::getName()));
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
