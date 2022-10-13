<?php

declare(strict_types=1);

namespace Fi1a\Unit\Console\IO;

use Fi1a\Console\IO\Stream;
use Fi1a\Console\IO\StreamConsoleInput;
use PHPUnit\Framework\TestCase;

/**
 * Потоковый ввод
 */
class StreamConsoleInputTest extends TestCase
{
    /**
     * Потоковый ввод
     */
    public function testConstruct(): void
    {
        $stream = new Stream('php://memory');
        $input = new StreamConsoleInput($stream);
        $this->assertInstanceOf(Stream::class, $input->getStream());
    }

    /**
     * Потоковый ввод
     */
    public function testRead(): void
    {
        $stream = new Stream('php://memory');
        $input = new StreamConsoleInput($stream);
        $stream->write('123');
        $stream->seek(0);
        $this->assertEquals('123', $input->read());
        $this->assertNull($input->read());
        $this->assertEquals('321', $input->read('321'));
    }
}
