<?php

declare(strict_types=1);

namespace Fi1a\Unit\Console\IO\AST;

use Fi1a\Console\IO\AST\AST;
use Fi1a\Console\IO\AST\Grid;
use Fi1a\Console\IO\AST\Style;
use Fi1a\Console\IO\AST\SymbolsInterface;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

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
        $this->assertEquals("123456789\n0\n123456789\n0\n123456789\n0", $grid->getImage());

        $ast = new AST('', []);
        $grid = new Grid($ast->getSymbols());
        $this->assertTrue($grid->wordWrap(10, 0));
        $this->assertCount(0, $grid->getSymbols());

        $ast = new AST('1234567890 1234567890 1234567890', []);
        $grid = new Grid($ast->getSymbols());
        $this->assertTrue($grid->wordWrap(10, 1));
        $this->assertEquals("1234567890\n1234567890\n1234567890", $grid->getImage());
    }

    /**
     * Дополняет до заданной длины переданным символом
     */
    public function testPadAlignLeft(): void
    {
        $ast = new AST("1234567890\n1234567890\n1234567890", []);
        $grid = new Grid($ast->getSymbols());
        $this->assertTrue($grid->pad(12, 'a'));
        $this->assertEquals("1234567890a\n1234567890a\n1234567890a", $grid->getImage());
    }

    /**
     * Дополняет до заданной длины переданным символом
     */
    public function testPadAlignRight(): void
    {
        $ast = new AST("1234567890\n1234567890\n1234567890", []);
        $grid = new Grid($ast->getSymbols());
        $this->assertTrue($grid->pad(12, 'a', $grid::ALIGN_RIGHT));
        $this->assertEquals("a1234567890\na1234567890\na1234567890", $grid->getImage());
    }

    /**
     * Дополняет до заданной длины переданным символом
     */
    public function testPadAlignCenter(): void
    {
        $ast = new AST("1234567890\n1234567890\n1234567890", []);
        $grid = new Grid($ast->getSymbols());
        $this->assertTrue($grid->pad(13, 'a', $grid::ALIGN_CENTER));
        $this->assertEquals("a1234567890a\na1234567890a\na1234567890a", $grid->getImage());
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
        $this->assertEquals("aa1234567890aa\naa1234567890aa\naa1234567890aa", $grid->getImage());
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
        $this->assertEquals(
            "aaaaaaaaaa\naaaaaaaaaa\n1234567890\n1234567890\n1234567890",
            $grid->getImage()
        );
    }

    /**
     * Оборачивает в символы по количеству сверху
     */
    public function testWrapBottom(): void
    {
        $ast = new AST("1234567890\n1234567890\n1234567890", []);
        $grid = new Grid($ast->getSymbols());
        $this->assertTrue($grid->wrapBottom(2, 10, 'a'));
        $this->assertEquals(
            "1234567890\n1234567890\n1234567890\naaaaaaaaaa\naaaaaaaaaa",
            $grid->getImage()
        );
    }

    /**
     * Установить значение
     */
    public function testSetValue(): void
    {
        $ast = new AST("1234567890\n1234567890\n1234567890", []);
        $grid = new Grid($ast->getSymbols());
        $this->assertEquals('1', $grid->getSymbols()[0]->getValue());
        $this->assertEquals('1', $grid->getSymbols()[11]->getValue());
        $this->assertTrue($grid->setValue(1, 1, 'a'));
        $this->assertEquals('a', $grid->getSymbols()[0]->getValue());
        $this->assertTrue($grid->setValue(2, 1, 'a'));
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

    /**
     * Добавить справа
     */
    public function testAppendRight(): void
    {
        $astRight = new AST("1234567890\n1234567890\n1234567890", []);

        $ast = new AST("1234567890\n1234567890\n1234567890", []);
        $grid = new Grid($ast->getSymbols());
        $grid->appendRight($astRight->getSymbols()->getArrayCopy());
        $this->assertEquals(
            "12345678901234567890\n12345678901234567890\n12345678901234567890",
            $grid->getImage()
        );

        $ast = new AST('', []);
        $grid = new Grid($ast->getSymbols());
        $grid->appendRight($astRight->getSymbols()->getArrayCopy());
        $this->assertEquals(
            "1234567890\n1234567890\n1234567890",
            $grid->getImage()
        );

        $ast = new AST("1234567890\n1234567890\n1234567890\n1234567890", []);
        $grid = new Grid($ast->getSymbols());
        $grid->appendRight($astRight->getSymbols()->getArrayCopy());
        $this->assertEquals(
            "12345678901234567890\n12345678901234567890\n12345678901234567890\n1234567890          ",
            $grid->getImage()
        );

        $ast = new AST("1234567890\n1234567890", []);
        $grid = new Grid($ast->getSymbols());
        $grid->appendRight($astRight->getSymbols()->getArrayCopy());
        $this->assertEquals(
            "12345678901234567890\n12345678901234567890\n          1234567890",
            $grid->getImage()
        );
    }
}
