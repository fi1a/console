<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\PanelComponent;

use Fi1a\Console\Component\AlignTrait;
use Fi1a\Console\Component\HeightTrait;
use Fi1a\Console\Component\PaddingTrait;
use Fi1a\Console\Component\WidthTrait;
use InvalidArgumentException;

/**
 * Стиль
 */
class PanelStyle implements PanelStyleInterface
{
    use WidthTrait;
    use HeightTrait;
    use AlignTrait;
    use PaddingTrait;

    /**
     * @var string|null
     */
    private $border;

    /**
     * @var string|null
     */
    private $leftBorderColor;

    /**
     * @var string|null
     */
    private $rightBorderColor;

    /**
     * @var string|null
     */
    private $topBorderColor;

    /**
     * @var string|null
     */
    private $bottomBorderColor;

    /**
     * @var string|null
     */
    private $backgroundColor;

    /**
     * @var string|null
     */
    private $color;

    /**
     * @inheritDoc
     */
    public function getBorder(): ?string
    {
        return $this->border;
    }

    /**
     * @inheritDoc
     */
    public function setBorder(?string $border)
    {
        if (!is_null($border) && !BorderRegistry::has($border)) {
            throw new InvalidArgumentException(
                sprintf('Ошибка в переданном значении "%s" границ', $border)
            );
        }

        $this->border = $border;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setBorderColor(?string $color)
    {
        $this->setLeftBorderColor($color)
            ->setRightBorderColor($color)
            ->setTopBorderColor($color)
            ->setBottomBorderColor($color);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setLeftBorderColor(?string $color)
    {
        $this->leftBorderColor = $color;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getLeftBorderColor(): ?string
    {
        return $this->leftBorderColor;
    }

    /**
     * @inheritDoc
     */
    public function setRightBorderColor(?string $color)
    {
        $this->rightBorderColor = $color;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRightBorderColor(): ?string
    {
        return $this->rightBorderColor;
    }

    /**
     * @inheritDoc
     */
    public function setTopBorderColor(?string $color)
    {
        $this->topBorderColor = $color;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getTopBorderColor(): ?string
    {
        return $this->topBorderColor;
    }

    /**
     * @inheritDoc
     */
    public function setBottomBorderColor(?string $color)
    {
        $this->bottomBorderColor = $color;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getBottomBorderColor(): ?string
    {
        return $this->bottomBorderColor;
    }

    /**
     * @inheritDoc
     */
    public function setBackgroundColor(?string $color)
    {
        $this->backgroundColor = $color;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getBackgroundColor(): ?string
    {
        return $this->backgroundColor;
    }

    /**
     * @inheritDoc
     */
    public function setColor(?string $color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getColor(): ?string
    {
        return $this->color;
    }
}
