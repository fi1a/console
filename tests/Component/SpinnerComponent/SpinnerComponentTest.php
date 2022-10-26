<?php

declare(strict_types=1);

namespace Fi1a\Unit\Console\Component\SpinnerComponent;

use Fi1a\Console\Component\SpinnerComponent\SpinnerComponent;
use Fi1a\Console\Component\SpinnerComponent\SpinnerStyle;
use Fi1a\Console\IO\ConsoleOutput;
use Fi1a\Console\IO\Formatter;
use Fi1a\Console\IO\Stream;
use PHPUnit\Framework\TestCase;

/**
 * Спиннер
 */
class SpinnerComponentTest extends TestCase
{
    /**
     * Отобразить
     */
    public function testDisplay(): void
    {
        $output = new ConsoleOutput(new Formatter());
        $output->setStream(new Stream('php://memory'));
        $style = new SpinnerStyle();
        $spinner = new SpinnerComponent($output, $style);
        $spinner->setTitle('In progress');
        for ($index = 0; $index < 20; $index++) {
            if ($index % 2 === 0) {
                $spinner->clear();
            }
            $this->assertTrue($spinner->display());
        }
    }

    /**
     * Отобразить
     */
    public function testDisplayTemplate(): void
    {
        $output = new ConsoleOutput(new Formatter());
        $output->setStream(new Stream('php://memory'));
        $style = new SpinnerStyle();
        $style->setTemplate('{{spinner}}{{if(title)}} {{title}}{{endif}}');
        $spinner = new SpinnerComponent($output, $style);
        $spinner->setTitle('In progress');
        for ($index = 0; $index < 20; $index++) {
            if ($index % 2 === 0) {
                $spinner->clear();
            }
            $this->assertTrue($spinner->display());
        }
    }

    /**
     * Отобразить
     */
    public function testDisplayLineSpinner(): void
    {
        $output = new ConsoleOutput(new Formatter());
        $output->setStream(new Stream('php://memory'));
        $style = new SpinnerStyle();
        $style->setSpinner('line');
        $spinner = new SpinnerComponent($output, $style);
        for ($index = 0; $index < 20; $index++) {
            if ($index % 2 === 0) {
                $spinner->clear();
            }
            $this->assertTrue($spinner->display());
        }
    }

    /**
     * Отобразить
     */
    public function testDisplayGrowVerticalSpinner(): void
    {
        $output = new ConsoleOutput(new Formatter());
        $output->setStream(new Stream('php://memory'));
        $style = new SpinnerStyle();
        $style->setSpinner('growVertical');
        $spinner = new SpinnerComponent($output, $style);
        for ($index = 0; $index < 20; $index++) {
            if ($index % 2 === 0) {
                $spinner->clear();
            }
            $this->assertTrue($spinner->display());
        }
    }
}
