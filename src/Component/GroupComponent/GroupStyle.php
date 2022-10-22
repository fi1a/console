<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\GroupComponent;

use Fi1a\Console\Component\HeightTrait;
use InvalidArgumentException;

/**
 * Стиль
 */
class GroupStyle implements GroupStyleInterface
{
    use HeightTrait;

    /**
     * @var int|null
     */
    private $panelSpacing;

    /**
     * @var int
     * @psalm-suppress PropertyNotSetInConstructor
     */
    private $width;

    /**
     * @inheritDoc
     */
    public function __construct(int $width, ?int $panelSpacing = null)
    {
        $this->setWidth($width);
        $this->setPanelSpacing($panelSpacing);
    }

    /**
     * @inheritDoc
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * @inheritDoc
     */
    public function setWidth(int $width)
    {
        if ($width <= 0) {
            throw new InvalidArgumentException('Ширина должна быть больше 0');
        }

        $this->width = $width;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setPanelSpacing(?int $panelSpacing)
    {
        $this->panelSpacing = $panelSpacing;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getPanelSpacing(): ?int
    {
        return $this->panelSpacing;
    }
}
