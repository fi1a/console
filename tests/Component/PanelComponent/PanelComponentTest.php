<?php

declare(strict_types=1);

namespace Fi1a\Unit\Console\Component\PanelComponent;

use Fi1a\Console\Component\PanelComponent\PanelComponent;
use Fi1a\Console\Component\PanelComponent\PanelStyle;
use Fi1a\Console\IO\ConsoleOutput;
use Fi1a\Console\IO\Formatter;
use Fi1a\Console\IO\OutputInterface;
use Fi1a\Console\IO\Stream;
use Fi1a\Console\IO\Style\ColorInterface;
use PHPUnit\Framework\TestCase;

/**
 * Вывод текста в панели
 */
class PanelComponentTest extends TestCase
{
    /**
     * Отобразить
     */
    public function testDisplay(): void
    {
        $output = new ConsoleOutput(new Formatter());
        $output->setStream(new Stream('php://memory'));
        $style = new PanelStyle();
        $style->setPadding(1)
            ->setWidth(20)
            ->setBorder('ascii')
            ->setBackgroundColor(ColorInterface::YELLOW)
            ->setBorderColor(ColorInterface::YELLOW)
            ->setHeight(10);
        $panel = new PanelComponent($output, 'Lorem', $style);
        $this->assertTrue($panel->display());

        $style->setHeight(1);
        $panel = new PanelComponent($output, 'Lorem', $style);
        $this->assertTrue($panel->display());
    }

    /**
     * Отобразить
     */
    public function testDisplayPanel(): void
    {
        $output = new ConsoleOutput(new Formatter());
        $output->setStream(new Stream('php://memory'));
        $style = new PanelStyle();
        $style->setPadding(1)
            ->setWidth(1)
            ->setBorder('ascii')
            ->setBackgroundColor(ColorInterface::YELLOW)
            ->setBorderColor(ColorInterface::YELLOW)
            ->setHeight(10);

        $style2 = new PanelStyle();
        $style2->setWidth(20);
        $panel2 = new PanelComponent(
            $output,
            'Lorem Ipsum Dolor Sit Amet Lorem Ipsum Dolor Sit Amet',
            $style2
        );

        $panel = new PanelComponent($output, ['Lorem', $panel2], $style);
        $this->assertTrue($panel->display());
    }

    /**
     * Отобразить
     */
    public function testDisplayBorderHeavy(): void
    {
        $output = new ConsoleOutput(new Formatter());
        $output->setStream(new Stream('php://memory'));
        $style = new PanelStyle();
        $style->setWidth(20)
            ->setBorder('heavy');
        $panel = new PanelComponent($output, 'Lorem', $style);
        $this->assertTrue($panel->display());
    }

    /**
     * Отобразить
     */
    public function testDisplayBorderHorizontals(): void
    {
        $output = new ConsoleOutput(new Formatter());
        $output->setStream(new Stream('php://memory'));
        $style = new PanelStyle();
        $style->setWidth(20)
            ->setBorder('horizontals');
        $panel = new PanelComponent($output, 'Lorem', $style);
        $this->assertTrue($panel->display());
    }

    /**
     * Отобразить
     */
    public function testDisplayBorderRounded(): void
    {
        $output = new ConsoleOutput(new Formatter());
        $output->setStream(new Stream('php://memory'));
        $style = new PanelStyle();
        $style->setWidth(20)
            ->setBorder('rounded');
        $panel = new PanelComponent($output, 'Lorem', $style);
        $this->assertTrue($panel->display());
    }

    /**
     * Отобразить
     */
    public function testDisplayBorderDouble(): void
    {
        $output = new ConsoleOutput(new Formatter());
        $output->setStream(new Stream('php://memory'));
        $style = new PanelStyle();
        $style->setWidth(20)
            ->setBorder('double');
        $panel = new PanelComponent($output, 'Lorem', $style);
        $this->assertTrue($panel->display());
    }

    /**
     * Отобразить
     */
    public function testDisplayBorderNone(): void
    {
        $output = new ConsoleOutput(new Formatter());
        $output->setStream(new Stream('php://memory'));
        $style = new PanelStyle();
        $style->setWidth(20);
        $panel = new PanelComponent($output, 'Lorem', $style);
        $this->assertTrue($panel->display());
    }

    /**
     * Не отображаем при отключенном выводе
     */
    public function testDisplayOnVerboseNone(): void
    {
        $output = new ConsoleOutput(new Formatter());
        $output->setVerbose(OutputInterface::VERBOSE_NONE);
        $style = new PanelStyle();
        $style->setPadding(1)
            ->setWidth(20)
            ->setBorder('ascii')
            ->setBackgroundColor(ColorInterface::YELLOW)
            ->setBorderColor(ColorInterface::YELLOW)
            ->setHeight(10);
        $panel = new PanelComponent($output, 'Lorem', $style);
        $this->assertTrue($panel->display());
    }
}
