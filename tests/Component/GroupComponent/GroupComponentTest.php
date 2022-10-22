<?php

declare(strict_types=1);

namespace Fi1a\Unit\Console\Component\GroupComponent;

use Fi1a\Console\Component\GroupComponent\GroupComponent;
use Fi1a\Console\Component\GroupComponent\GroupStyle;
use Fi1a\Console\Component\PanelComponent\PanelComponent;
use Fi1a\Console\Component\PanelComponent\PanelStyle;
use Fi1a\Console\Component\Rectangle;
use Fi1a\Console\IO\ConsoleOutput;
use Fi1a\Console\IO\Formatter;
use Fi1a\Console\IO\Stream;
use Fi1a\Console\IO\Style\ColorInterface;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * Группа панелей
 */
class GroupComponentTest extends TestCase
{
    /**
     * Отображение
     */
    public function testDisplay(): void
    {
        $output = new ConsoleOutput(new Formatter());
        $output->setStream(new Stream('php://memory'));
        $style = new PanelStyle();
        $style->setPadding(1)
            ->setBorder($style::BORDER_ASCII)
            ->setBackgroundColor(ColorInterface::YELLOW)
            ->setBorderColor(ColorInterface::YELLOW)
            ->setHeight(10);
        $panel1 = new PanelComponent($output, 'Lorem', $style);
        $panel2 = new PanelComponent($output, "Lorem\nLorem", $style);
        $panel3 = new PanelComponent($output, "Lorem\nLorem\nLorem\nLorem", $style);

        $groupStyle = new GroupStyle(20, 1);
        $group = new GroupComponent($output, $groupStyle, [$panel1]);
        $group->addPanel($panel2);
        $group->addPanel($panel3);

        $this->assertTrue($group->display());
    }

    /**
     * Отображение
     */
    public function testDisplayPanelWidth(): void
    {
        $output = new ConsoleOutput(new Formatter());
        $output->setStream(new Stream('php://memory'));
        $style = new PanelStyle();
        $style->setPadding(1)
            ->setBorder($style::BORDER_ASCII)
            ->setBackgroundColor(ColorInterface::YELLOW)
            ->setBorderColor(ColorInterface::YELLOW)
            ->setWidth(30);
        $panel1 = new PanelComponent($output, 'Lorem', $style);
        $panel2 = new PanelComponent($output, "Lorem\nLorem", $style);
        $panel3 = new PanelComponent($output, "Lorem\nLorem\nLorem\nLorem", $style);

        $groupStyle = new GroupStyle(20, 1);
        $group = new GroupComponent($output, $groupStyle, [$panel1]);
        $group->addPanel($panel2);
        $group->addPanel($panel3);

        $this->assertTrue($group->display());
    }

    /**
     * Отображение (без панелей)
     */
    public function testDisplayEmptyPanels(): void
    {
        $output = new ConsoleOutput(new Formatter());
        $output->setStream(new Stream('php://memory'));

        $groupStyle = new GroupStyle(20, 1);
        $group = new GroupComponent($output, $groupStyle);

        $this->assertTrue($group->display());
    }

    /**
     * Отображение (без панелей)
     */
    public function testGetSymbolsEmptyPanels(): void
    {
        $output = new ConsoleOutput(new Formatter());
        $output->setStream(new Stream('php://memory'));

        $groupStyle = new GroupStyle(20, 1);
        $group = new GroupComponent($output, $groupStyle);

        $rectangle = new Rectangle(
            20
        );

        $this->assertCount(0, $group->getSymbols($rectangle));
    }

    /**
     * Исключение
     */
    public function testSetPanelsException(): void
    {
        $output = new ConsoleOutput(new Formatter());
        $output->setStream(new Stream('php://memory'));

        $this->expectException(InvalidArgumentException::class);
        $groupStyle = new GroupStyle(20, 1);
        new GroupComponent($output, $groupStyle, [$this]);
    }
}
