<?php

declare(strict_types=1);

namespace Fi1a\Unit\Console\IO;

use Fi1a\Console\IO\ConsoleOutput;
use Fi1a\Console\IO\Cursor;
use Fi1a\Console\IO\Formatter;
use Fi1a\Console\IO\Stream;
use PHPUnit\Framework\TestCase;

/**
 * Курсор
 */
class CursorTest extends TestCase
{
    /**
     * Очистить консоль
     */
    public function testClear(): void
    {
        $output = new ConsoleOutput(new Formatter());
        $output->setStream(new Stream('php://memory', 'w'));
        $errorOutput = $output->getErrorOutput();
        /**
         * @var ConsoleOutput $errorOutput
         */
        $errorOutput->setStream(new Stream('php://memory', 'w'));
        $cursor = new Cursor($output);
        $this->assertTrue($cursor->clear());
    }

    /**
     * Звучит 'звонок'
     */
    public function testBell(): void
    {
        $output = new ConsoleOutput(new Formatter());
        $output->setStream(new Stream('php://memory', 'w'));
        $errorOutput = $output->getErrorOutput();
        /**
         * @var ConsoleOutput $errorOutput
         */
        $errorOutput->setStream(new Stream('php://memory', 'w'));
        $cursor = new Cursor($output);
        $this->assertTrue($cursor->bell());
    }

    /**
     * Переместить курсор в "домашнюю" позицию
     */
    public function testHome(): void
    {
        $output = new ConsoleOutput(new Formatter());
        $output->setStream(new Stream('php://memory', 'w'));
        $errorOutput = $output->getErrorOutput();
        /**
         * @var ConsoleOutput $errorOutput
         */
        $errorOutput->setStream(new Stream('php://memory', 'w'));
        $cursor = new Cursor($output);
        $this->assertTrue($cursor->home());
    }

    /**
     * Переместить курсор
     */
    public function testMove(): void
    {
        $output = new ConsoleOutput(new Formatter());
        $output->setStream(new Stream('php://memory', 'w'));
        $errorOutput = $output->getErrorOutput();
        /**
         * @var ConsoleOutput $errorOutput
         */
        $errorOutput->setStream(new Stream('php://memory', 'w'));
        $cursor = new Cursor($output);
        $this->assertTrue($cursor->move(1, 1));
    }

    /**
     * Переместить курсор
     */
    public function testMoveTo(): void
    {
        $output = new ConsoleOutput(new Formatter());
        $output->setStream(new Stream('php://memory', 'w'));
        $errorOutput = $output->getErrorOutput();
        /**
         * @var ConsoleOutput $errorOutput
         */
        $errorOutput->setStream(new Stream('php://memory', 'w'));
        $cursor = new Cursor($output);
        $this->assertTrue($cursor->moveTo(1, 1));
    }

    /**
     * Спрятать курсор
     */
    public function testHideCursor(): void
    {
        $output = new ConsoleOutput(new Formatter());
        $output->setStream(new Stream('php://memory', 'w'));
        $errorOutput = $output->getErrorOutput();
        /**
         * @var ConsoleOutput $errorOutput
         */
        $errorOutput->setStream(new Stream('php://memory', 'w'));
        $cursor = new Cursor($output);
        $this->assertTrue($cursor->hideCursor());
    }

    /**
     * Показать курсор
     */
    public function testShowCursor(): void
    {
        $output = new ConsoleOutput(new Formatter());
        $output->setStream(new Stream('php://memory', 'w'));
        $errorOutput = $output->getErrorOutput();
        /**
         * @var ConsoleOutput $errorOutput
         */
        $errorOutput->setStream(new Stream('php://memory', 'w'));
        $cursor = new Cursor($output);
        $this->assertTrue($cursor->showCursor());
    }

    /**
     * Установить заголовок
     */
    public function testSetTitle(): void
    {
        $output = new ConsoleOutput(new Formatter());
        $output->setStream(new Stream('php://memory', 'w'));
        $errorOutput = $output->getErrorOutput();
        /**
         * @var ConsoleOutput $errorOutput
         */
        $errorOutput->setStream(new Stream('php://memory', 'w'));
        $cursor = new Cursor($output);
        $this->assertTrue($cursor->setTitle('Title'));
    }
}
