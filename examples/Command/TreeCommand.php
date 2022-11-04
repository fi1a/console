<?php

declare(strict_types=1);

namespace Fi1a\Console\Examples\Command;

use Fi1a\Console\AbstractCommand;
use Fi1a\Console\AppInterface;
use Fi1a\Console\Component\TreeComponent\TreeComponent;
use Fi1a\Console\Component\TreeComponent\TreeStyle;
use Fi1a\Console\Definition\DefinitionInterface;
use Fi1a\Console\IO\ConsoleOutputInterface;
use Fi1a\Console\IO\InputArgumentsInterface;
use Fi1a\Console\IO\InputInterface;

/**
 * Дерево
 */
class TreeCommand extends AbstractCommand
{
    /**
     * @inheritDoc
     */
    public function __construct(DefinitionInterface $definition)
    {
    }

    /**
     * @inheritDoc
     */
    public function run(
        InputArgumentsInterface $input,
        ConsoleOutputInterface $output,
        InputInterface $stream,
        DefinitionInterface $definition,
        AppInterface $app
    ): int {
        $output->writeln(['', '<option=bold>Дерево</>', '']);

        $style = new TreeStyle();
        $style->setWidth(20)
            ->setLine('heavy');

        $tree = new TreeComponent($output);

        $node1 = $tree->addNode('Lorem ipsum dolor', $style);
        $node1->addNode('Ex ea commodo consequat', $style);
        $node2 = $tree->addNode('Consectetur adipiscing elit', $style);
        $node3 = $node2->addNode('Ex ea commodo consequat', $style);
        $node2->addNode('Sunt in culpa qui officia', $style);
        $node3->addNode('Ut aliquip ex ea commodo');
        $node3->addNode('Sunt in culpa qui officia');
        $tree->addNode('Ut enim ad minim veniam', $style);

        $tree->display();

        $output->writeln('');

        return 0;
    }

    /**
     * @inheritDoc
     */
    public function description(): ?string
    {
        return 'Дерево';
    }
}
