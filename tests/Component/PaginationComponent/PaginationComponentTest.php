<?php

declare(strict_types=1);

namespace Fi1a\Unit\Console\Component\PaginationComponent;

use Fi1a\Console\Component\PaginationComponent\PaginationComponent;
use Fi1a\Console\Component\PaginationComponent\PaginationStyle;
use Fi1a\Console\IO\ConsoleInput;
use Fi1a\Console\IO\ConsoleOutput;
use Fi1a\Console\IO\Formatter;
use Fi1a\Console\IO\InputInterface;
use Fi1a\Console\IO\Stream;
use Fi1a\Console\IO\StreamInput;
use Fi1a\Console\IO\Style\TrueColor;
use PHPUnit\Framework\TestCase;

use const PHP_EOL;

/**
 * Постраничная навигация
 */
class PaginationComponentTest extends TestCase
{
    /**
     * @var ConsoleOutput
     */
    private static $output;

    /**
     * @var InputInterface
     */
    private static $input;

    /**
     * @inheritDoc
     */
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        static::$output = new ConsoleOutput(new Formatter());
        static::$output->setStream(new Stream('php://memory', 'w'));
        /**
         * @var ConsoleOutput $errorOutput
         */
        $errorOutput = static::$output->getErrorOutput();
        $errorOutput->setStream(new Stream('php://memory', 'w'));
        static::$input = new StreamInput(new Stream('php://temp', 'w'));
    }

    /**
     * Пагинация без страниц
     */
    public function testPaginationNoPages(): void
    {
        $output = new ConsoleOutput(new Formatter());
        $output->setStream(new Stream('php://memory'));
        $style = new PaginationStyle();

        $pagination = new PaginationComponent(static::$output, static::$input, $style);
        $this->assertTrue(true);
        while ($pagination->isValid()) {
            $this->assertFalse(true);
        }
    }

    /**
     * Пагинация
     */
    public function testPagination()
    {
        static::$input->getStream()->write(
            'n' . PHP_EOL . PHP_EOL . 'p' . PHP_EOL . '50' . PHP_EOL . '110' . PHP_EOL . 'abc'
            . PHP_EOL . ConsoleInput::getEscapeSymbol()
        );
        static::$input->getStream()->seek(0);
        $style = new PaginationStyle();
        $style->setColor(TrueColor::WHITE)
            ->setBackgroundColor(TrueColor::GREEN);
        $pagination = new PaginationComponent(static::$output, static::$input, $style);
        $pagination->setCount(100);
        $pagination->setCurrent(110);
        $pagination->setCurrent(1);
        while ($pagination->isValid()) {
            static::$output->writeln(['', 'Display' . $pagination->getCurrent(),]);
            $pagination->display();
        }
        $this->assertTrue(true);
    }
}
