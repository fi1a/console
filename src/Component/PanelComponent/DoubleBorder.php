<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\PanelComponent;

/**
 * Double
 */
class DoubleBorder implements BorderInterface
{
    /**
     * @inheritDoc
     */
    public function getHBorder(): string
    {
        return '═';
    }

    /**
     * @inheritDoc
     */
    public function getVBorder(): string
    {
        return '║';
    }

    /**
     * @inheritDoc
     */
    public function getLeftTopCorner(): string
    {
        return '╔';
    }

    /**
     * @inheritDoc
     */
    public function getRightTopCorner(): string
    {
        return '╗';
    }

    /**
     * @inheritDoc
     */
    public function getLeftBottomCorner(): string
    {
        return '╚';
    }

    /**
     * @inheritDoc
     */
    public function getRightBottomCorner(): string
    {
        return '╝';
    }
}
