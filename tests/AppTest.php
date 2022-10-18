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
use Fi1a\Unit\Console\Fixtures\CommandFixtureWithoutDescription;
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
    public function testRunByName(): void
    {
        $input = new ArrayInputArguments(['command1']);
        $output = new ConsoleOutput(new Formatter());
        $stream = new StreamInput(new Stream('php://memory'));
        $code = (new App($input, $output, $stream))
            ->addCommand('command1', CommandFixture::class)
            ->addCommand('command2', CommandFixture::class)
            ->run();
        $this->assertEquals(0, $code);
    }

    /**
     * Запуск команды
     */
    public function testRunInfo(): void
    {
        $input = new ArrayInputArguments(['--verbose=none']);
        $output = new ConsoleOutput(new Formatter());
        $stream = new StreamInput(new Stream('php://memory'));
        $code = (new App($input, $output, $stream))
            ->addCommand('command1', CommandFixture::class)
            ->addCommand('command2', CommandFixture::class)
            ->run();
        $this->assertEquals(0, $code);
    }

    /**
     * Запуск команды
     */
    public function testRunUnknown(): void
    {
        $input = new ArrayInputArguments(['unknown', '--verbose=none']);
        $output = new ConsoleOutput(new Formatter());
        $output->setVerbose(ConsoleOutput::VERBOSE_NONE);
        $stream = new StreamInput(new Stream('php://memory'));
        $code = (new App($input, $output, $stream))
            ->addCommand('command1', CommandFixture::class)
            ->addCommand('command2', CommandFixture::class)
            ->run();
        $this->assertEquals(1, $code);
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
        $input = new ArrayInputArguments(['--unknown=1', '--verbose=none']);
        $output = new ConsoleOutput(new Formatter());
        $output->setVerbose(ConsoleOutput::VERBOSE_NONE);
        $stream = new StreamInput(new Stream('php://memory'));
        $code = (new App($input, $output, $stream))
            ->run(CommandFixture::class);
        $this->assertEquals(1, $code);
    }

    /**
     * Запуск команды
     */
    public function testRunValidationError(): void
    {
        $input = new ArrayInputArguments(['--option1=abc', '--verbose=none']);
        $output = new ConsoleOutput(new Formatter());
        $output->setVerbose(ConsoleOutput::VERBOSE_NONE);
        $stream = new StreamInput(new Stream('php://memory'));
        $code = (new App($input, $output, $stream))
            ->run(CommandFixture::class);
        $this->assertEquals(1, $code);
    }

    /**
     * Методы работы с командами
     */
    public function testCommands(): void
    {
        $app = new App();
        $this->assertFalse($app->hasCommand('command1'));
        $this->assertFalse($app->getCommand('command1'));
        $app->addCommand('command1', CommandFixture::class);
        $this->assertTrue($app->hasCommand('command1'));
        $this->assertCount(2, $app->allCommands());
        $this->assertEquals(CommandFixture::class, $app->getCommand('command1'));
        $this->assertTrue($app->deleteCommand('command1'));
        $this->assertFalse($app->deleteCommand('command1'));
    }

    /**
     * Исключение при пустом имени команды
     */
    public function testAddCommandExisting(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $app = new App();
        $app->addCommand('command1', CommandFixture::class);
        $app->addCommand('command1', CommandFixture::class);
    }

    /**
     * Исключение при пустом имени команды
     */
    public function testAddCommandEmptyName(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $app = new App();
        $app->addCommand('', '');
    }

    /**
     * Исключение при пустом имени команды
     */
    public function testHasCommandEmptyName(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $app = new App();
        $app->hasCommand('');
    }

    /**
     * Исключение при пустом имени команды
     */
    public function testGetCommandEmptyName(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $app = new App();
        $app->getCommand('');
    }

    /**
     * Исключение при пустом имени команды
     */
    public function testDeleteCommandEmptyName(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $app = new App();
        $app->deleteCommand('');
    }

    /**
     * Исключение при пустом имени команды
     */
    public function testAddCommandSubbclass(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $app = new App();
        $app->addCommand('command1', static::class);
    }

    /**
     * Цвета консоли
     */
    public function testColorsExt(): void
    {
        $input = new ArrayInputArguments(['--colors=ext', '--verbose=none']);
        $output = new ConsoleOutput(new Formatter());
        $stream = new StreamInput(new Stream('php://memory'));
        $code = (new App($input, $output, $stream))
            ->run();
        $this->assertEquals(0, $code);
    }

    /**
     * Цвета консоли
     */
    public function testColorsTrueColor(): void
    {
        $input = new ArrayInputArguments(['--colors=trueColor', '--verbose=none']);
        $output = new ConsoleOutput(new Formatter());
        $stream = new StreamInput(new Stream('php://memory'));
        $code = (new App($input, $output, $stream))
            ->run();
        $this->assertEquals(0, $code);
    }

    /**
     * Цвета консоли
     */
    public function testColorsNone(): void
    {
        $input = new ArrayInputArguments(['--colors=none', '--verbose=none']);
        $output = new ConsoleOutput(new Formatter());
        $stream = new StreamInput(new Stream('php://memory'));
        $code = (new App($input, $output, $stream))
            ->run();
        $this->assertEquals(0, $code);
    }

    /**
     * Цвета консоли
     */
    public function testColorsAnsi(): void
    {
        $input = new ArrayInputArguments(['--colors=ansi', '--verbose=none']);
        $output = new ConsoleOutput(new Formatter());
        $stream = new StreamInput(new Stream('php://memory'));
        $code = (new App($input, $output, $stream))
            ->run();
        $this->assertEquals(0, $code);
    }

    /**
     * Цвета консоли
     */
    public function testColorsUnknown(): void
    {
        $input = new ArrayInputArguments(['--colors=unknown', '--verbose=none']);
        $output = new ConsoleOutput(new Formatter());
        $output->setVerbose(ConsoleOutput::VERBOSE_NONE);
        $stream = new StreamInput(new Stream('php://memory'));
        $code = (new App($input, $output, $stream))
            ->run();
        $this->assertEquals(1, $code);
    }

    /**
     * Цвета консоли
     */
    public function testVerboseUnknown(): void
    {
        $input = new ArrayInputArguments(['--verbose=unknown']);
        $output = new ConsoleOutput(new Formatter());
        $output->setVerbose(ConsoleOutput::VERBOSE_NONE);
        $stream = new StreamInput(new Stream('php://memory'));
        $code = (new App($input, $output, $stream))
            ->run();
        $this->assertEquals(1, $code);
    }

    /**
     * Вызов справки по команде
     */
    public function testRunHelp(): void
    {
        $input = new ArrayInputArguments(['command1', '--help=Y', '--verbose=none']);
        $output = new ConsoleOutput(new Formatter());
        $output->setVerbose(ConsoleOutput::VERBOSE_NONE);
        $stream = new StreamInput(new Stream('php://memory'));
        $code = (new App($input, $output, $stream))
            ->addCommand('command1', CommandFixture::class)
            ->run();
        $this->assertEquals(0, $code);
    }

    /**
     * Вызов справки по команде
     */
    public function testRunHelpWithoutDescription(): void
    {
        $input = new ArrayInputArguments(['command2', '--help=Y', '--verbose=none']);
        $output = new ConsoleOutput(new Formatter());
        $output->setVerbose(ConsoleOutput::VERBOSE_NONE);
        $stream = new StreamInput(new Stream('php://memory'));
        $code = (new App($input, $output, $stream))
            ->addCommand('command2', CommandFixtureWithoutDescription::class)
            ->run();
        $this->assertEquals(0, $code);
    }
}
