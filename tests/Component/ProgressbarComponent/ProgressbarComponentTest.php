<?php

declare(strict_types=1);

namespace Fi1a\Unit\Console\Component\ProgressbarComponent;

use Fi1a\Console\Component\ProgressbarComponent\ProgressbarComponent;
use Fi1a\Console\Component\ProgressbarComponent\ProgressbarStyle;
use Fi1a\Console\IO\ConsoleOutput;
use Fi1a\Console\IO\Formatter;
use Fi1a\Console\IO\OutputInterface;
use Fi1a\Console\IO\Stream;
use PHPUnit\Framework\TestCase;

/**
 * Прогрессбар
 */
class ProgressbarComponentTest extends TestCase
{
    /**
     * Отобразить
     */
    public function testDisplay(): void
    {
        $output = new ConsoleOutput(new Formatter());
        $output->setStream(new Stream('php://memory'));
        $style = new ProgressbarStyle();
        $progressbar = new ProgressbarComponent($output, $style);
        $progressbar->setTitle('Progress..');
        $this->assertTrue($progressbar->clear());
        $progressbar->start(100);
        for ($index = 0; $index < 100; $index++) {
            $this->assertTrue($progressbar->clear());
            $progressbar->increment();
        }
        $progressbar->finish();
    }

    /**
     * Отобразить
     */
    public function testDisplayWithoutMaxSteps(): void
    {
        $output = new ConsoleOutput(new Formatter());
        $output->setStream(new Stream('php://memory'));
        $style = new ProgressbarStyle();
        $progressbar = new ProgressbarComponent($output, $style);
        $progressbar->start();
        for ($index = 0; $index < 100; $index++) {
            $progressbar->increment();
            $this->assertTrue(true);
        }
        $progressbar->finish();
    }

    /**
     * Отобразить
     */
    public function testDisplayMaxSteps(): void
    {
        $output = new ConsoleOutput(new Formatter());
        $output->setStream(new Stream('php://memory'));
        $style = new ProgressbarStyle();
        $progressbar = new ProgressbarComponent($output, $style);
        $progressbar->start(10);
        for ($index = 0; $index < 100; $index++) {
            $progressbar->increment();
            $this->assertTrue(true);
        }
        $progressbar->finish();
    }

    /**
     * Не отображаем при отключенном выводе
     */
    public function testDisplayOnVerboseNone(): void
    {
        $output = new ConsoleOutput(new Formatter());
        $output->setVerbose(OutputInterface::VERBOSE_NONE);
        $style = new ProgressbarStyle();
        $progressbar = new ProgressbarComponent($output, $style);
        $progressbar->start(10);
        for ($index = 0; $index < 100; $index++) {
            $progressbar->increment();
            $this->assertTrue(true);
        }
        $progressbar->finish();
    }
}
