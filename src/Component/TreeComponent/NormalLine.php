<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\TreeComponent;

/**
 * Normal
 */
class NormalLine implements LineInterface
{
    /**
     * @inheritDoc
     */
    public function getVerticalLine(): string
    {
        return '│';
    }

    /**
     * @inheritDoc
     */
    public function getEndLine(): string
    {
        return '└──';
    }

    /**
     * @inheritDoc
     */
    public function getMiddleLine(): string
    {
        return '├──';
    }
}
