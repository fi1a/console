<?php

declare(strict_types=1);

namespace Fi1a\Unit\Console\IO\AST;

use Fi1a\Console\IO\AST\Style;
use Fi1a\Console\IO\AST\Styles;
use Fi1a\Console\IO\AST\StylesInterface;
use PHPUnit\Framework\TestCase;

/**
 * Коллекция стилей
 */
class StylesTest extends TestCase
{
    /**
     * @var StylesInterface
     */
    private static $styles;

    /**
     * Вычисляемые стили
     */
    public function testComputedStyle(): void
    {
        static::$styles = new Styles();
        static::$styles->add(new Style(null, 'yellow'));
        static::$styles->add(new Style(null, 'red', 'white'));
        static::$styles->add(new Style(null, null, null, ['bold']));
        $computed = static::$styles->getComputedStyle();
        $this->assertEquals('red', $computed->getColor());
        $this->assertEquals('white', $computed->getBackground());
        $this->assertEquals(['bold'], $computed->getOptions());
    }

    /**
     * Вычисляемые стили (кеш)
     *
     * @depends testComputedStyle
     */
    public function testComputedStyleCache(): void
    {
        $computed = static::$styles->getComputedStyle();
        $this->assertEquals('red', $computed->getColor());
        $this->assertEquals('white', $computed->getBackground());
        $this->assertEquals(['bold'], $computed->getOptions());
        static::$styles->add(new Style(null, null, null, []));
        $this->assertTrue(static::$styles->resetComputedStyleCache());
        $computed = static::$styles->getComputedStyle();
        $this->assertEquals('red', $computed->getColor());
        $this->assertEquals('white', $computed->getBackground());
        $this->assertEquals([], $computed->getOptions());
    }
}
