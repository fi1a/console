<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\PanelComponent;

use Fi1a\Console\Component\AlignTrait;
use Fi1a\Console\Component\HeightTrait;
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

    /**
     * @var string|null
     */
    private $border = self::BORDER_NONE;

    /**
     * @var int|null
     */
    private $paddingLeft;

    /**
     * @var int|null
     */
    private $paddingRight;

    /**
     * @var int|null
     */
    private $paddingBottom;

    /**
     * @var int|null
     */
    private $paddingTop;

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
        if (!is_null($border)) {
            $border = mb_strtolower($border);
            if (
                !in_array(
                    $border,
                    [
                        self::BORDER_ASCII, self::BORDER_DOUBLE, self::BORDER_HEAVY, self::BORDER_HORIZONTALS,
                        self::BORDER_NONE, self::BORDER_ROUNDED,
                    ]
                )
            ) {
                throw new InvalidArgumentException(
                    sprintf('Ошибка в переданном значении "%s" границ', $border)
                );
            }
        }

        $this->border = $border;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setPadding(?int $padding)
    {
        $this->setPaddingLeft(is_null($padding) ? $padding : $padding * 3)
            ->setPaddingRight(is_null($padding) ? $padding : $padding * 3)
            ->setPaddingBottom($padding)
            ->setPaddingTop($padding);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setPaddingLeft(?int $padding)
    {
        $this->paddingLeft = $padding;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getPaddingLeft(): ?int
    {
        return $this->paddingLeft;
    }

    /**
     * @inheritDoc
     */
    public function setPaddingTop(?int $padding)
    {
        $this->paddingTop = $padding;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getPaddingTop(): ?int
    {
        return $this->paddingTop;
    }

    /**
     * @inheritDoc
     */
    public function setPaddingRight(?int $padding)
    {
        $this->paddingRight = $padding;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getPaddingRight(): ?int
    {
        return $this->paddingRight;
    }

    /**
     * @inheritDoc
     */
    public function setPaddingBottom(?int $padding)
    {
        $this->paddingBottom = $padding;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getPaddingBottom(): ?int
    {
        return $this->paddingBottom;
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
}
