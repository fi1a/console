<?php

declare(strict_types=1);

namespace Fi1a\Unit\Console\IO;

use Fi1a\Console\IO\ConsoleOutput;
use Fi1a\Console\IO\Formatter\Formatter;
use PHPUnit\Framework\TestCase;

/**
 * Тестирование консольного вывода
 */
class ConsoleOutputTest extends TestCase
{
    /**
     * @var ConsoleOutput
     */
    private static $output = null;

    /**
     * Создание
     */
    public function testConstruct()
    {
        static::$output = new ConsoleOutput(new Formatter());
        $this->assertInstanceOf(ConsoleOutput::class, static::$output);
    }

    /**
     * Установка уровня подробности вывода
     *
     * @depends testConstruct
     */
    public function testSetVerbose()
    {
        static::$output->setVerbose(ConsoleOutput::VERBOSE_HIGHTEST);
        $this->assertEquals(ConsoleOutput::VERBOSE_HIGHTEST, static::$output->getVerbose());
        $this->assertEquals(ConsoleOutput::VERBOSE_HIGHTEST, static::$output->getErrorOutput()->getVerbose());
        static::$output->setVerbose(ConsoleOutput::VERBOSE_NORMAL);
    }
}
