<?php

declare(strict_types=1);

namespace Fi1a\Unit\Console\IO;

use Fi1a\Console\IO\Formatter;
use Fi1a\Console\IO\Style\ANSIColor;
use Fi1a\Console\IO\Style\ANSIStyle;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * Тестирование форматирование текста
 */
class FormatterTest extends TestCase
{
    /**
     * @var Formatter
     */
    private static $formatter = null;

    /**
     * Конструктор
     */
    public function testConstruct()
    {
        static::$formatter = new Formatter();

        $this->assertTrue(true);
    }

    /**
     * Исключение
     */
    public function testStyleClassException()
    {
        $this->expectException(InvalidArgumentException::class);
        new Formatter(static::class);
    }

    /**
     * Добавление стиля
     *
     * @depends testConstruct
     */
    public function testAddStyle()
    {
        $this->assertTrue(static::$formatter->addStyle(
            'style',
            new ANSIStyle(ANSIColor::WHITE, ANSIColor::RED)
        ));
        $this->assertFalse(static::$formatter->addStyle(
            'style',
            new ANSIStyle(ANSIColor::WHITE, ANSIColor::RED)
        ));
    }

    /**
     * Проверка стиля
     *
     * @depends testAddStyle
     */
    public function testHasStyle()
    {
        $this->assertTrue(static::$formatter->hasStyle('error'));
        $this->assertFalse(static::$formatter->hasStyle('not_exist'));
    }

    /**
     * Форматирование
     *
     * @depends testHasStyle
     */
    public function testFormat()
    {
        $this->assertTrue(is_string(
            static::$formatter->format('<error>Error text</error> <comment>com<info>men</info>t</comment>')
        ));
        $this->assertTrue(is_string(
            static::$formatter->format('<error>Error text</>')
        ));
        $this->assertTrue(is_string(
            static::$formatter->format('<not_exist>Error text</not_exist>')
        ));
        $this->assertTrue(is_string(
            static::$formatter->format('<color=black;bg=white;option=bold;>Error text</>')
        ));
    }

    /**
     * @depends testFormat
     */
    public function testFormatException()
    {
        $this->expectException(InvalidArgumentException::class);
        static::$formatter->format('<error>Error text</error></error> test');
    }

    /**
     * Возвращает стиль
     *
     * @depends testHasStyle
     */
    public function testGetStyle()
    {
        $this->assertInstanceOf(ANSIStyle::class, static::$formatter->getStyle('error'));
        $this->assertFalse(static::$formatter->getStyle('not_exist'));
        $this->assertInstanceOf(
            ANSIStyle::class,
            static::$formatter->getStyle('black;bg=white;option=bold;option=not_exist;')
        );
    }

    /**
     * Удаление стиля
     *
     * @depends testHasStyle
     */
    public function testDeleteStyle()
    {
        $this->assertTrue(static::$formatter->deleteStyle('style'));
        $this->assertFalse(static::$formatter->deleteStyle('style'));
    }
}
