<?php

declare(strict_types=1);

namespace Fi1a\Unit\Console\IO;

use Fi1a\Console\IO\Formatter\Formatter;
use Fi1a\Console\IO\Stream;
use Fi1a\Console\IO\StreamOutput;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * Вывод в поток
 */
class StreamOutputTest extends TestCase
{
    /**
     * @var StreamOutput
     */
    private static $output;

    /**
     * Создание
     */
    public function testConstruct()
    {
        static::$output = new StreamOutput(new Stream('php://memory', 'w'), new Formatter());
        $this->assertInstanceOf(StreamOutput::class, static::$output);
        $this->assertInstanceOf(Stream::class, static::$output->getStream());
    }

    /**
     * Создание
     */
    public function testConstructEmptyResource()
    {
        $output = new StreamOutput(new Stream(), new Formatter());
        $this->assertInstanceOf(StreamOutput::class, $output);
    }

    /**
     * Вывод
     *
     * @depends testConstruct
     */
    public function testWriteln()
    {
        $this->assertTrue(static::$output->writeln('test'));
    }

    /**
     * Создание
     */
    public function testConstructDecorate()
    {
        static::$output = new StreamOutput(new Stream('php://memory', 'w'), new Formatter(), true);
        $this->assertInstanceOf(StreamOutput::class, static::$output);
    }

    /**
     * Вывод
     *
     * @depends testConstructDecorate
     */
    public function testWrite()
    {
        $this->assertTrue(static::$output->write('test'));
    }

    /**
     * Вывод
     *
     * @depends testConstructDecorate
     */
    public function testWriteFormatter()
    {
        $this->assertTrue(static::$output->write(
            '{{if(key1)}}{{key2}}{{endif}}',
            ['key1' => 1, 'key2' => 2,]
        ));
    }

    /**
     * Вывод с использованием уровня подробности
     */
    public function testVerbose()
    {
        static::$output->setVerbose(StreamOutput::VERBOSE_NONE);
        $this->assertTrue(static::$output->writeln('test'));
        static::$output->setVerbose(StreamOutput::VERBOSE_NORMAL);
    }

    /**
     * Исключение при передаче аргумента
     */
    public function testVerboseException()
    {
        $this->expectException(InvalidArgumentException::class);
        static::$output->setVerbose(100);
    }

    /**
     * Создание
     */
    public function testWriteError()
    {
        $output = new StreamOutput(new Stream('php://memory', 'r'), new Formatter(), true);
        $this->assertInstanceOf(StreamOutput::class, $output);
        $this->assertFalse($output->writeln('test'));
    }
}
