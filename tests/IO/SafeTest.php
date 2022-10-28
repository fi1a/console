<?php

declare(strict_types=1);

namespace Fi1a\Unit\Console\IO;

use Fi1a\Console\IO\Safe;
use PHPUnit\Framework\TestCase;

/**
 * Экранирование
 */
class SafeTest extends TestCase
{
    /**
     * Экранирование
     */
    public function testEscape(): void
    {
        $this->assertEquals(
            '\\<error>Error\\\\ text\\</error>',
            Safe::escape('<error>Error\\ text</error>')
        );
    }

    /**
     * Экранирование
     */
    public function testUnescape(): void
    {
        $this->assertEquals(
            '<error>Error\\ text</error>',
            Safe::unescape('\\<error>Error\\\\ text\\</error>')
        );
    }
}
