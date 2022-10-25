<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\TreeComponent;

/**
 * Узел
 */
class TreeNode implements TreeNodeInterface
{
    use TreeNodeTrait;

    /**
     * Конструктор
     *
     * @param TreeNode[] $nodes
     */
    public function __construct(string $title, array $nodes = [], ?TreeStyleInterface $style = null)
    {
        $this->setTitle($title)
            ->setStyle($style)
            ->setNodes($nodes);
    }
}
