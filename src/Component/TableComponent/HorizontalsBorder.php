<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\TableComponent;

/**
 * Horizontals границы
 */
class HorizontalsBorder implements BorderInterface
{
    /**
     * @inheritDoc
     */
    public function getHBorder(): string
    {
        return ' ';
    }

    /**
     * @inheritDoc
     */
    public function getHBorderHeader(): string
    {
        return '━';
    }

    /**
     * @inheritDoc
     */
    public function getHBorderTop(): string
    {
        return $this->getHBorderHeader();
    }

    /**
     * @inheritDoc
     */
    public function getHBorderBottom(): string
    {
        return $this->getHBorderHeader();
    }

    /**
     * @inheritDoc
     */
    public function getVBorder(): string
    {
        return ' ';
    }

    /**
     * @inheritDoc
     */
    public function getVBorderLeft(): string
    {
        return $this->getVBorder();
    }

    /**
     * @inheritDoc
     */
    public function getVBorderRight(): string
    {
        return $this->getVBorder();
    }

    /**
     * @inheritDoc
     */
    public function getLeftTopCorner(): string
    {
        return ' ';
    }

    /**
     * @inheritDoc
     */
    public function getRightTopCorner(): string
    {
        return ' ';
    }

    /**
     * @inheritDoc
     */
    public function getLeftBottomCorner(): string
    {
        return ' ';
    }

    /**
     * @inheritDoc
     */
    public function getRightBottomCorner(): string
    {
        return ' ';
    }

    /**
     * @inheritDoc
     */
    public function getTopCrossing(): string
    {
        return '━';
    }

    /**
     * @inheritDoc
     */
    public function getLeftCrossing(): string
    {
        return ' ';
    }

    /**
     * @inheritDoc
     */
    public function getRightCrossing(): string
    {
        return ' ';
    }

    /**
     * @inheritDoc
     */
    public function getBottomCrossing(): string
    {
        return '━';
    }

    /**
 * @inheritDoc
 */
    public function getCrossing(): string
    {
        return '━';
    }
}
