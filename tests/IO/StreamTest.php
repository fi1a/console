<?php

declare(strict_types=1);

namespace Fi1a\Unit\Console\IO;

use Fi1a\Console\IO\Stream;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

use const PHP_EOL;

/**
 * Поток
 */
class StreamTest extends TestCase
{
    /**
     * Открытие и закрытие потока
     */
    public function testOpenCloseStream()
    {
        $stream = new Stream('php://memory');
        $this->assertIsResource($stream->getStream());
        $this->assertTrue($stream->close());
        $stream->open('php://temp', 'w');
        $this->assertIsResource($stream->getStream());
    }

    /**
     * Открытие и закрытие потока
     */
    public function testOpenCloseEmptyStream()
    {
        $stream = new Stream();
        $this->assertFalse($stream->close());
    }

    /**
     * Установка потока
     */
    public function testSetStream()
    {
        $stream = new Stream('php://memory', 'w');
        $this->assertIsResource($stream->getStream());
    }

    /**
     * Исключение при ошибочном значении
     */
    public function testSetStreamException()
    {
        $this->expectException(InvalidArgumentException::class);
        (new Stream('php://memory', 'r'))->setStream('');
    }

    /**
     * Чтение и запись
     */
    public function testReadWrite()
    {
        $stream = new Stream('php://memory', 'w');
        $stream->seek(0);
        $stream->write('123');
        $stream->seek(0);
        $this->assertEquals('123', $stream->read(3));
        $stream->seek(0);
        $stream->write('123', 3);
        $stream->flush();
        $stream->seek(0);
        $this->assertEquals('123', $stream->read(3));
        $stream->seek(0);
        $stream->write('1' . PHP_EOL);
        $stream->write('2' . PHP_EOL);
        $stream->seek(0);
        $this->assertEquals('1' . PHP_EOL, $stream->gets());
        $this->assertEquals('2' . PHP_EOL, $stream->gets());
    }

    /**
     * Чтение и запись
     */
    public function testReadWriteEmptyStream()
    {
        $stream = new Stream();
        $this->assertEquals(0, $stream->write('1'));
        $this->assertEquals('', $stream->read(10));
        $this->assertFalse($stream->gets());
        $this->assertFalse($stream->flush());
        $this->assertEquals(0, $stream->seek(1));
    }
}
