<?php

declare(strict_types=1);

namespace Fi1a\Unit\Console\Component\TreeComponent;

use Fi1a\Console\Component\PanelComponent\PanelComponent;
use Fi1a\Console\Component\PanelComponent\PanelStyle;
use Fi1a\Console\Component\Rectangle;
use Fi1a\Console\Component\TreeComponent\TreeComponent;
use Fi1a\Console\Component\TreeComponent\TreeNode;
use Fi1a\Console\Component\TreeComponent\TreeStyle;
use Fi1a\Console\IO\ConsoleOutput;
use Fi1a\Console\IO\Formatter;
use Fi1a\Console\IO\Stream;
use Fi1a\Console\IO\Style\ColorInterface;
use Fi1a\Console\IO\Style\TrueColor;
use PHPUnit\Framework\TestCase;

/**
 * Дерево
 */
class TreeComponentTest extends TestCase
{
    /**
     * Отобразить
     */
    public function testDisplay(): void
    {
        $output = new ConsoleOutput(new Formatter());
        $output->setStream(new Stream('php://memory'));

        $treeStyle = new TreeStyle();
        $treeStyle->setWidth(50)
            ->setLineColor(TrueColor::YELLOW);

        $tree = new TreeComponent($output);

        $tree->addNode('Node 1');

        $node2 = $tree->addNode('Node 2');

        $node2->addNode('Node 2.1');
        $node2->setText('Text node 2.1');
        $node2->setStyle($treeStyle);

        $node22 = $node2->addNode('Node 2.2');
        $style = new PanelStyle();
        $style->setPadding(1)
            ->setWidth(20)
            ->setBorder('ascii')
            ->setBackgroundColor(ColorInterface::YELLOW)
            ->setBorderColor(ColorInterface::YELLOW)
            ->setHeight(10);
        $panel = new PanelComponent($output, 'Lorem', $style);
        $node22->setText(['Lorem', $panel, 'Ipsum']);

        $node2->addNode('Node 2.3');

        $tree->addNode('Node 3');

        $this->assertTrue($tree->display());
    }

    /**
     * Отобразить
     */
    public function testDisplaySetNodes(): void
    {
        $output = new ConsoleOutput(new Formatter());
        $output->setStream(new Stream('php://memory'));

        $tree = new TreeComponent($output);

        $tree->setNodes([
            new TreeNode('Node 1'),
            new TreeNode('Node 2', [
                new TreeNode('Node 2.1'),
                new TreeNode('Node 2.2'),
                new TreeNode('Node 2.3'),
            ]),
            new TreeNode('Node 3'),
        ]);

        $this->assertTrue($tree->display());
    }

    /**
     * Отобразить
     */
    public function testDisplayLineAscii(): void
    {
        $output = new ConsoleOutput(new Formatter());
        $output->setStream(new Stream('php://memory'));

        $style = new TreeStyle();
        $style->setLineType($style::LINE_ASCII);

        $tree = new TreeComponent($output);

        $tree->setNodes([
            new TreeNode('Node 1', [], $style),
            new TreeNode('Node 2', [
                new TreeNode('Node 2.1', [], $style),
                new TreeNode('Node 2.2', [], $style),
                new TreeNode('Node 2.3', [], $style),
            ], $style),
            new TreeNode('Node 3', [], $style),
        ]);

        $this->assertTrue($tree->display());
    }

    /**
     * Отобразить
     */
    public function testDisplayLineDouble(): void
    {
        $output = new ConsoleOutput(new Formatter());
        $output->setStream(new Stream('php://memory'));

        $style = new TreeStyle();
        $style->setLineType($style::LINE_DOUBLE);

        $tree = new TreeComponent($output);

        $tree->setNodes([
            new TreeNode('Node 1', [], $style),
            new TreeNode('Node 2', [
                new TreeNode('Node 2.1', [], $style),
                new TreeNode('Node 2.2', [], $style),
                new TreeNode('Node 2.3', [], $style),
            ], $style),
            new TreeNode('Node 3', [], $style),
        ]);

        $this->assertTrue($tree->display());
    }

    /**
     * Отобразить
     */
    public function testDisplayLineHeavy(): void
    {
        $output = new ConsoleOutput(new Formatter());
        $output->setStream(new Stream('php://memory'));

        $style = new TreeStyle();
        $style->setLineType($style::LINE_HEAVY);

        $tree = new TreeComponent($output);

        $tree->setNodes([
            new TreeNode('Node 1', [], $style),
            new TreeNode('Node 2', [
                new TreeNode('Node 2.1', [], $style),
                new TreeNode('Node 2.2', [], $style),
                new TreeNode('Node 2.3', [], $style),
            ], $style),
            new TreeNode('Node 3', [], $style),
        ]);

        $this->assertTrue($tree->display());
    }

    /**
     * Отобразить при пустом дереве
     */
    public function testDisplayEmptyNodes(): void
    {
        $output = new ConsoleOutput(new Formatter());
        $output->setStream(new Stream('php://memory'));
        $tree = new TreeComponent($output);
        $this->assertTrue($tree->display());
    }

    /**
     * Отобразить при пустом дереве
     */
    public function testGetSymbolsEmptyNodes(): void
    {
        $output = new ConsoleOutput(new Formatter());
        $output->setStream(new Stream('php://memory'));

        $tree = new TreeComponent($output);
        $rectangle = new Rectangle();
        $this->assertCount(0, $tree->getSymbols($rectangle));
    }
}
