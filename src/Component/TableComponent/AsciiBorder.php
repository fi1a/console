<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\TableComponent;

/**
 * ASCII границы
 */
class AsciiBorder implements BorderInterface
{
    /**
     * @inheritDoc
     */
    public function getHBorder(): string
    {
        return '-';
    }

    /**
     * @inheritDoc
     */
    public function getHBorderHeader(): string
    {
        return $this->getHBorder();
    }

    /**
     * @inheritDoc
     */
    public function getHBorderTop(): string
    {
        return $this->getHBorder();
    }

    /**
     * @inheritDoc
     */
    public function getHBorderBottom(): string
    {
        return $this->getHBorder();
    }

    /**
     * @inheritDoc
     */
    public function getVBorder(): string
    {
        return '|';
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
        return $this->getCrossing();
    }

    /**
     * @inheritDoc
     */
    public function getRightTopCorner(): string
    {
        return $this->getCrossing();
    }

    /**
     * @inheritDoc
     */
    public function getLeftBottomCorner(): string
    {
        return $this->getCrossing();
    }

    /**
     * @inheritDoc
     */
    public function getRightBottomCorner(): string
    {
        return $this->getCrossing();
    }

    /**
     * @inheritDoc
     */
    public function getTopCrossing(): string
    {
        return $this->getCrossing();
    }

    /**
     * @inheritDoc
     */
    public function getLeftCrossing(): string
    {
        return $this->getCrossing();
    }

    /**
     * @inheritDoc
     */
    public function getRightCrossing(): string
    {
        return $this->getCrossing();
    }

    /**
     * @inheritDoc
     */
    public function getBottomCrossing(): string
    {
        return $this->getCrossing();
    }

    /**
     * @inheritDoc
     */
    public function getCrossing(): string
    {
        return '+';
    }
}
