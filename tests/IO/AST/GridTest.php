<?php

declare(strict_types=1);

namespace Fi1a\Unit\Console\IO\AST;

use Fi1a\Console\IO\AST\AST;
use Fi1a\Console\IO\AST\Grid;
use Fi1a\Console\IO\AST\Style;
use Fi1a\Console\IO\AST\SymbolsInterface;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

use const PHP_EOL;

/**
 * Работа с символами используя линии и колонки
 */
class GridTest extends TestCase
{
    /**
     * Символы
     */
    public function testSetAndGetSymbols(): void
    {
        $grid = new Grid();
        $this->assertInstanceOf(SymbolsInterface::class, $grid->getSymbols());
    }

    /**
     * Перенос по ширине
     */
    public function testWordWrap(): void
    {
        $ast = new AST('1234567890 1234567890 1234567890', []);
        $grid = new Grid($ast->getSymbols());
        $this->assertTrue($grid->wordWrap(10, 0));
        $this->assertEquals(PHP_EOL, $grid->getSymbols()[9]->getValue());
        $this->assertEquals(PHP_EOL, $grid->getSymbols()[21]->getValue());
        $this->assertEquals(PHP_EOL, $grid->getSymbols()[33]->getValue());

        $ast = new AST('', []);
        $grid = new Grid($ast->getSymbols());
        $this->assertTrue($grid->wordWrap(10, 0));
        $this->assertCount(0, $grid->getSymbols());

        $ast = new AST('1234567890 1234567890 1234567890', []);
        $grid = new Grid($ast->getSymbols());
        $this->assertTrue($grid->wordWrap(10, 1));
        $this->assertEquals('0', $grid->getSymbols()[9]->getValue());
        $this->assertEquals('0', $grid->getSymbols()[20]->getValue());
        $this->assertEquals('0', $grid->getSymbols()[31]->getValue());
    }

    /**
     * Дополняет до заданной длины переданным символом
     */
    public function testPadAlignLeft(): void
    {
        $ast = new AST("1234567890\n1234567890\n1234567890", []);
        $grid = new Grid($ast->getSymbols());
        $this->assertTrue($grid->pad(12, 'a'));
        $this->assertEquals('a', $grid->getSymbols()[10]->getValue());
        $this->assertEquals('a', $grid->getSymbols()[22]->getValue());
        $this->assertEquals('a', $grid->getSymbols()[34]->getValue());
    }

    /**
     * Дополняет до заданной длины переданным символом
     */
    public function testPadAlignRight(): void
    {
        $ast = new AST("1234567890\n1234567890\n1234567890", []);
        $grid = new Grid($ast->getSymbols());
        $this->assertTrue($grid->pad(12, 'a', $grid::ALIGN_RIGHT));
        $this->assertEquals('a', $grid->getSymbols()[0]->getValue());
        $this->assertEquals('a', $grid->getSymbols()[12]->getValue());
        $this->assertEquals('a', $grid->getSymbols()[24]->getValue());
    }

    /**
     * Дополняет до заданной длины переданным символом
     */
    public function testPadAlignCenter(): void
    {
        $ast = new AST("1234567890\n1234567890\n1234567890", []);
        $grid = new Grid($ast->getSymbols());
        $this->assertTrue($grid->pad(13, 'a', $grid::ALIGN_CENTER));

        $this->assertEquals('a', $grid->getSymbols()[0]->getValue());
        $this->assertEquals('a', $grid->getSymbols()[11]->getValue());

        $this->assertEquals('a', $grid->getSymbols()[13]->getValue());
        $this->assertEquals('a', $grid->getSymbols()[24]->getValue());

        $this->assertEquals('a', $grid->getSymbols()[26]->getValue());
        $this->assertEquals('a', $grid->getSymbols()[37]->getValue());
    }

    /**
     * Дополняет до заданной длины переданным символом
     */
    public function testPadAlignException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $ast = new AST("1234567890\n1234567890\n1234567890", []);
        $grid = new Grid($ast->getSymbols());
        $grid->pad(13, 'a', 'unknown');
    }

    /**
     * Оборачивает в символы по количеству с двух сторон
     */
    public function testWrap(): void
    {
        $ast = new AST("1234567890\n1234567890\n1234567890", []);
        $grid = new Grid($ast->getSymbols());
        $this->assertTrue($grid->wrap(2, 'a'));
        $this->assertEquals('a', $grid->getSymbols()[0]->getValue());
        $this->assertEquals('a', $grid->getSymbols()[12]->getValue());
    }

    /**
     * Оборачивает в символы по количеству с двух сторон
     */
    public function testWrapEmpty(): void
    {
        $ast = new AST('', []);
        $grid = new Grid($ast->getSymbols());
        $this->assertTrue($grid->wrap(2, 'a'));
        $this->assertCount(0, $grid->getSymbols());
    }

    /**
     * Оборачивает в символы по количеству сверху
     */
    public function testWrapTop(): void
    {
        $ast = new AST("1234567890\n1234567890\n1234567890", []);
        $grid = new Grid($ast->getSymbols());
        $this->assertTrue($grid->wrapTop(2, 10, 'a'));
        $this->assertEquals('a', $grid->getSymbols()[0]->getValue());
        $this->assertEquals('a', $grid->getSymbols()[12]->getValue());
    }

    /**
     * Оборачивает в символы по количеству сверху
     */
    public function testWrapBottom(): void
    {
        $ast = new AST("1234567890\n1234567890\n1234567890", []);
        $grid = new Grid($ast->getSymbols());
        $this->assertTrue($grid->wrapBottom(2, 10, 'a'));
        $this->assertEquals('a', $grid->getSymbols()[40]->getValue());
        $this->assertEquals('a', $grid->getSymbols()[41]->getValue());
    }

    /**
     * Установить значение
     */
    public function testSet(): void
    {
        $ast = new AST("1234567890\n1234567890\n1234567890", []);
        $grid = new Grid($ast->getSymbols());
        $this->assertEquals('1', $grid->getSymbols()[0]->getValue());
        $this->assertEquals('1', $grid->getSymbols()[11]->getValue());
        $this->assertTrue($grid->set(1, 1, 'a'));
        $this->assertEquals('a', $grid->getSymbols()[0]->getValue());
        $this->assertTrue($grid->set(2, 1, 'a'));
        $this->assertEquals('a', $grid->getSymbols()[11]->getValue());
    }

    /**
     * Возвращает высоту
     */
    public function testGetHeight(): void
    {
        $ast = new AST("1234567890\n1234567890\n1234567890", []);
        $grid = new Grid($ast->getSymbols());
        $this->assertEquals(3, $grid->getHeight());
    }

    /**
     * Добавить в начало стили
     */
    public function testPrependStyles(): void
    {
        $ast = new AST("1234567890\n1234567890\n1234567890", []);
        $grid = new Grid($ast->getSymbols());
        $this->assertCount(0, $grid->getSymbols()[0]->getStyles());
        $this->assertTrue($grid->prependStyles([new Style('cls1')]));
        $this->assertCount(1, $grid->getSymbols()[0]->getStyles());
        $this->assertTrue($grid->prependStyles([new Style('cls2')]));
        $this->assertCount(2, $grid->getSymbols()[0]->getStyles());
        $this->assertEquals('cls2', $grid->getSymbols()[0]->getStyles()[0]->getStyleName());
        $this->assertEquals('cls1', $grid->getSymbols()[0]->getStyles()[1]->getStyleName());
    }

    /**
     * Добавить в конец стили
     */
    public function testAppendStyles(): void
    {
        $ast = new AST("1234567890\n1234567890\n1234567890", []);
        $grid = new Grid($ast->getSymbols());
        $this->assertCount(0, $grid->getSymbols()[0]->getStyles());
        $this->assertTrue($grid->appendStyles([new Style('cls1')]));
        $this->assertCount(1, $grid->getSymbols()[0]->getStyles());
        $this->assertTrue($grid->appendStyles([new Style('cls2')]));
        $this->assertCount(2, $grid->getSymbols()[0]->getStyles());
        $this->assertEquals('cls1', $grid->getSymbols()[0]->getStyles()[0]->getStyleName());
        $this->assertEquals('cls2', $grid->getSymbols()[0]->getStyles()[1]->getStyleName());
    }

    /**
     * Обрезает по высоте
     */
    public function testTruncateHeight(): void
    {
        $ast = new AST("1234567890\n1234567890\n1234567890", []);
        $grid = new Grid($ast->getSymbols());
        $this->assertEquals(3, $grid->getHeight());
        $this->assertTrue($grid->truncateHeight(2));
        $this->assertEquals(2, $grid->getHeight());
    }
}
