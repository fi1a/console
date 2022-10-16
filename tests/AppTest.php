<?php

declare(strict_types=1);

namespace Fi1a\Unit\Console;

use Fi1a\Console\App;
use Fi1a\Console\IO\ArrayInputArguments;
use Fi1a\Console\IO\ConsoleOutput;
use Fi1a\Console\IO\Formatter;
use Fi1a\Console\IO\Stream;
use Fi1a\Console\IO\StreamInput;
use Fi1a\Unit\Console\Fixtures\CommandFixture;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * Консольное приложение
 */
class AppTest extends TestCase
{
    /**
     * Запуск команды
     */
    public function testRun(): void
    {
        $input = new ArrayInputArguments([]);
        $output = new ConsoleOutput(new Formatter());
        $stream = new StreamInput(new Stream('php://memory'));
        $code = (new App($input, $output, $stream))
            ->run(CommandFixture::class);
        $this->assertEquals(0, $code);
    }

    /**
     * Запуск команды
     */
    public function testRunCommandException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $input = new ArrayInputArguments([]);
        $output = new ConsoleOutput(new Formatter());
        $stream = new StreamInput(new Stream('php://memory'));
        (new App($input, $output, $stream))
            ->run(static::class);
    }

    /**
     * Запуск команды
     */
    public function testRunUnknownOption(): void
    {
        $input = new ArrayInputArguments(['--option1=1']);
        $output = new ConsoleOutput(new Formatter());
        $output->setVerbose(ConsoleOutput::VERBOSE_NONE);
        $stream = new StreamInput(new Stream('php://memory'));
        $code = (new App($input, $output, $stream))
            ->run(CommandFixture::class);
        $this->assertEquals(1, $code);
    }
}
