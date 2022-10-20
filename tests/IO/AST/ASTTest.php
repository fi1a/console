<?php

declare(strict_types=1);

namespace Fi1a\Unit\Console\IO\AST;

use Fi1a\Console\IO\Formatter\AST\AST;
use Fi1a\Console\IO\Formatter\AST\Exception\SyntaxErrorException;
use Fi1a\Console\IO\Formatter\AST\Style;
use Fi1a\Console\IO\Formatter\AST\SymbolInterface;
use Fi1a\Console\IO\Formatter\Formatter;
use Fi1a\Console\IO\Style\Bold;
use Fi1a\Console\IO\Style\StyleConverter;
use Fi1a\Console\IO\Style\TrueColorStyle;
use PHPUnit\Framework\TestCase;

/**
 * AST
 */
class ASTTest extends TestCase
{
    /**
     * Кейс 1
     */
    public function testCase1(): void
    {
        $ast = new AST(
            'text <error>error</error> text',
            StyleConverter::convertArray(Formatter::allStyles())
        );
        /**
         * @var SymbolInterface[] $symbols
         */
        $symbols = $ast->getSymbols();
        $this->assertCount(15, $symbols);

        $this->assertEquals('t', $symbols[0]->getValue());
        $this->assertNull($symbols[0]->getStyles()->getComputedStyle()->getColor());
        $this->assertNull($symbols[0]->getStyles()->getComputedStyle()->getBackground());
        $this->assertNull($symbols[0]->getStyles()->getComputedStyle()->getOptions());

        $this->assertEquals('e', $symbols[5]->getValue());
        $this->assertEquals('white', $symbols[5]->getStyles()->getComputedStyle()->getColor());
        $this->assertEquals('red', $symbols[5]->getStyles()->getComputedStyle()->getBackground());
        $this->assertNull($symbols[5]->getStyles()->getComputedStyle()->getOptions());
    }

    /**
     * Кейс 2
     */
    public function testCase2(): void
    {
        $ast = new AST(
            'text <error><success>e</success>rror</error> text',
            StyleConverter::convertArray(Formatter::allStyles())
        );
        /**
         * @var SymbolInterface[] $symbols
         */
        $symbols = $ast->getSymbols();
        $this->assertCount(15, $symbols);

        $this->assertEquals('t', $symbols[0]->getValue());
        $this->assertNull($symbols[0]->getStyles()->getComputedStyle()->getColor());
        $this->assertNull($symbols[0]->getStyles()->getComputedStyle()->getBackground());
        $this->assertNull($symbols[0]->getStyles()->getComputedStyle()->getOptions());

        $this->assertEquals('e', $symbols[5]->getValue());
        $this->assertEquals('black', $symbols[5]->getStyles()->getComputedStyle()->getColor());
        $this->assertEquals('green', $symbols[5]->getStyles()->getComputedStyle()->getBackground());
        $this->assertNull($symbols[5]->getStyles()->getComputedStyle()->getOptions());

        $this->assertEquals('r', $symbols[6]->getValue());
        $this->assertEquals('white', $symbols[6]->getStyles()->getComputedStyle()->getColor());
        $this->assertEquals('red', $symbols[6]->getStyles()->getComputedStyle()->getBackground());
        $this->assertNull($symbols[6]->getStyles()->getComputedStyle()->getOptions());
    }

    /**
     * Кейс 3
     */
    public function testCase3(): void
    {
        $ast = new AST(
            'text <error>e<color=yellow>r</>ror</error> text',
            StyleConverter::convertArray(Formatter::allStyles())
        );
        /**
         * @var SymbolInterface[] $symbols
         */
        $symbols = $ast->getSymbols();
        $this->assertCount(15, $symbols);

        $this->assertEquals('t', $symbols[0]->getValue());
        $this->assertNull($symbols[0]->getStyles()->getComputedStyle()->getColor());
        $this->assertNull($symbols[0]->getStyles()->getComputedStyle()->getBackground());
        $this->assertNull($symbols[0]->getStyles()->getComputedStyle()->getOptions());

        $this->assertEquals('e', $symbols[5]->getValue());
        $this->assertEquals('white', $symbols[5]->getStyles()->getComputedStyle()->getColor());
        $this->assertEquals('red', $symbols[5]->getStyles()->getComputedStyle()->getBackground());
        $this->assertNull($symbols[5]->getStyles()->getComputedStyle()->getOptions());

        $this->assertEquals('r', $symbols[6]->getValue());
        $this->assertEquals('yellow', $symbols[6]->getStyles()->getComputedStyle()->getColor());
        $this->assertEquals('red', $symbols[6]->getStyles()->getComputedStyle()->getBackground());
        $this->assertNull($symbols[6]->getStyles()->getComputedStyle()->getOptions());
    }

    /**
     * Кейс 4
     */
    public function testCase4(): void
    {
        $ast = new AST(
            'text < error >e< color = yellow >r</>ror</ error > text',
            StyleConverter::convertArray(Formatter::allStyles())
        );
        /**
         * @var SymbolInterface[] $symbols
         */
        $symbols = $ast->getSymbols();
        $this->assertCount(15, $symbols);

        $this->assertEquals('t', $symbols[0]->getValue());
        $this->assertNull($symbols[0]->getStyles()->getComputedStyle()->getColor());
        $this->assertNull($symbols[0]->getStyles()->getComputedStyle()->getBackground());
        $this->assertNull($symbols[0]->getStyles()->getComputedStyle()->getOptions());

        $this->assertEquals('e', $symbols[5]->getValue());
        $this->assertEquals('white', $symbols[5]->getStyles()->getComputedStyle()->getColor());
        $this->assertEquals('red', $symbols[5]->getStyles()->getComputedStyle()->getBackground());
        $this->assertNull($symbols[5]->getStyles()->getComputedStyle()->getOptions());

        $this->assertEquals('r', $symbols[6]->getValue());
        $this->assertEquals('yellow', $symbols[6]->getStyles()->getComputedStyle()->getColor());
        $this->assertEquals('red', $symbols[6]->getStyles()->getComputedStyle()->getBackground());
        $this->assertNull($symbols[6]->getStyles()->getComputedStyle()->getOptions());
    }

    /**
     * Кейс 5
     */
    public function testCase5(): void
    {
        $ast = new AST(
            'text <error>e<color>r</>ror</ error > text',
            StyleConverter::convertArray(Formatter::allStyles())
        );
        /**
         * @var SymbolInterface[] $symbols
         */
        $symbols = $ast->getSymbols();
        $this->assertCount(15, $symbols);

        $this->assertEquals('t', $symbols[0]->getValue());
        $this->assertNull($symbols[0]->getStyles()->getComputedStyle()->getColor());
        $this->assertNull($symbols[0]->getStyles()->getComputedStyle()->getBackground());
        $this->assertNull($symbols[0]->getStyles()->getComputedStyle()->getOptions());

        $this->assertEquals('e', $symbols[5]->getValue());
        $this->assertEquals('white', $symbols[5]->getStyles()->getComputedStyle()->getColor());
        $this->assertEquals('red', $symbols[5]->getStyles()->getComputedStyle()->getBackground());
        $this->assertNull($symbols[5]->getStyles()->getComputedStyle()->getOptions());

        $this->assertEquals('r', $symbols[6]->getValue());
        $this->assertEquals(null, $symbols[6]->getStyles()->getComputedStyle()->getColor());
        $this->assertEquals('red', $symbols[6]->getStyles()->getComputedStyle()->getBackground());
        $this->assertNull($symbols[6]->getStyles()->getComputedStyle()->getOptions());
    }

    /**
     * Кейс 6
     */
    public function testCase6(): void
    {
        $ast = new AST(
            'text <error>e<bg>r</>ror</ error > text',
            StyleConverter::convertArray(
                Formatter::allStyles() + ['bold' => new TrueColorStyle(null, null, [Bold::getName()])]
            )
        );
        /**
         * @var SymbolInterface[] $symbols
         */
        $symbols = $ast->getSymbols();
        $this->assertCount(15, $symbols);

        $this->assertEquals('t', $symbols[0]->getValue());
        $this->assertNull($symbols[0]->getStyles()->getComputedStyle()->getColor());
        $this->assertNull($symbols[0]->getStyles()->getComputedStyle()->getBackground());
        $this->assertNull($symbols[0]->getStyles()->getComputedStyle()->getOptions());

        $this->assertEquals('e', $symbols[5]->getValue());
        $this->assertEquals('white', $symbols[5]->getStyles()->getComputedStyle()->getColor());
        $this->assertEquals('red', $symbols[5]->getStyles()->getComputedStyle()->getBackground());
        $this->assertNull($symbols[5]->getStyles()->getComputedStyle()->getOptions());

        $this->assertEquals('r', $symbols[6]->getValue());
        $this->assertEquals('white', $symbols[6]->getStyles()->getComputedStyle()->getColor());
        $this->assertEquals(null, $symbols[6]->getStyles()->getComputedStyle()->getBackground());
        $this->assertNull($symbols[6]->getStyles()->getComputedStyle()->getOptions());
    }

    /**
     * Кейс 7
     */
    public function testCase7(): void
    {
        $ast = new AST(
            'text <error>e<option=bold, underscore>r</>ror</ error > text',
            StyleConverter::convertArray(Formatter::allStyles())
        );
        /**
         * @var SymbolInterface[] $symbols
         */
        $symbols = $ast->getSymbols();
        $this->assertCount(15, $symbols);

        $this->assertEquals('t', $symbols[0]->getValue());
        $this->assertNull($symbols[0]->getStyles()->getComputedStyle()->getColor());
        $this->assertNull($symbols[0]->getStyles()->getComputedStyle()->getBackground());
        $this->assertNull($symbols[0]->getStyles()->getComputedStyle()->getOptions());

        $this->assertEquals('e', $symbols[5]->getValue());
        $this->assertEquals('white', $symbols[5]->getStyles()->getComputedStyle()->getColor());
        $this->assertEquals('red', $symbols[5]->getStyles()->getComputedStyle()->getBackground());
        $this->assertNull($symbols[5]->getStyles()->getComputedStyle()->getOptions());

        $this->assertEquals('r', $symbols[6]->getValue());
        $this->assertEquals('white', $symbols[6]->getStyles()->getComputedStyle()->getColor());
        $this->assertEquals('red', $symbols[6]->getStyles()->getComputedStyle()->getBackground());
        $this->assertEquals(['bold', 'underscore'], $symbols[6]->getStyles()->getComputedStyle()->getOptions());
    }

    /**
     * Кейс 8
     */
    public function testCase8(): void
    {
        $ast = new AST(
            'text <option=bold, underscore>e<option>r</></>ror text',
            StyleConverter::convertArray(Formatter::allStyles())
        );
        /**
         * @var SymbolInterface[] $symbols
         */
        $symbols = $ast->getSymbols();
        $this->assertCount(15, $symbols);

        $this->assertEquals('e', $symbols[5]->getValue());
        $this->assertNull($symbols[5]->getStyles()->getComputedStyle()->getColor());
        $this->assertNull($symbols[5]->getStyles()->getComputedStyle()->getBackground());
        $this->assertEquals(['bold', 'underscore'], $symbols[5]->getStyles()->getComputedStyle()->getOptions());

        $this->assertEquals('r', $symbols[6]->getValue());
        $this->assertNull($symbols[6]->getStyles()->getComputedStyle()->getColor());
        $this->assertNull($symbols[6]->getStyles()->getComputedStyle()->getBackground());
        $this->assertNull($symbols[6]->getStyles()->getComputedStyle()->getOptions());
    }

    /**
     * Кейс 9
     */
    public function testCase9(): void
    {
        $ast = new AST(
            'text <option=bold, underscore>e<option>r</></>ror text',
            StyleConverter::convertArray(Formatter::allStyles()),
            new Style(null, 'red', 'white')
        );
        /**
         * @var SymbolInterface[] $symbols
         */
        $symbols = $ast->getSymbols();
        $this->assertCount(15, $symbols);

        $this->assertEquals('e', $symbols[5]->getValue());
        $this->assertEquals('red', $symbols[5]->getStyles()->getComputedStyle()->getColor());
        $this->assertEquals('white', $symbols[5]->getStyles()->getComputedStyle()->getBackground());
        $this->assertEquals(['bold', 'underscore'], $symbols[5]->getStyles()->getComputedStyle()->getOptions());

        $this->assertEquals('r', $symbols[6]->getValue());
        $this->assertEquals('red', $symbols[6]->getStyles()->getComputedStyle()->getColor());
        $this->assertEquals('white', $symbols[6]->getStyles()->getComputedStyle()->getBackground());
        $this->assertNull($symbols[6]->getStyles()->getComputedStyle()->getOptions());
    }

    /**
     * Провайдер данных для метода testExceptions
     *
     * @return string[][]
     */
    public function dataProviderExceptions(): array
    {
        return [
            // 0
            [
                'text <error>e<color=yellow,red>r</>ror</error> text',
            ],
            // 1
            [
                'text <unknown>error</unknown> text',
            ],
            // 2
            [
                '<',
            ],
            // 3
            [
                '<error',
            ],
            // 4
            [
                '< error',
            ],
            // 5
            [
                '< error ',
            ],
            // 6
            [
                '<>',
            ],
            // 7
            [
                '<color',
            ],
            // 8
            [
                '<color=',
            ],
            // 9
            [
                '<color=>',
            ],
            // 10
            [
                '< color = >',
            ],
            // 11
            [
                '< color ,>',
            ],
            // 12
            [
                '<color>',
            ],
            // 13
            [
                '</>',
            ],
        ];
    }

    /**
     * @dataProvider dataProviderExceptions
     */
    public function testExceptions(string $format): void
    {
        $this->expectException(SyntaxErrorException::class);
        new AST(
            $format,
            StyleConverter::convertArray(Formatter::allStyles())
        );
    }
}
