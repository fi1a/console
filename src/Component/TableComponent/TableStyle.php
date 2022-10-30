<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\TableComponent;

use Fi1a\Console\Component\PaddingTrait;
use Fi1a\Console\Component\WidthTrait;
use InvalidArgumentException;

/**
 * Стиль таблицы
 */
class TableStyle implements TableStyleInterface
{
    use WidthTrait;
    use PaddingTrait;

    /**
     * @var string|null
     */
    private $border = self::BORDER_ASCII;

    /**
     * @var string|null
     */
    private $color;

    /**
     * @var string|null
     */
    private $headerColor;

    /**
     * @var string|null
     */
    private $backgroundColor;

    /**
     * @var string|null
     */
    private $headerBackgroundColor;

    /**
     * @var string|null
     */
    private $borderColor;

    /**
     * Конструктор
     */
    public function __construct(?int $width = null, ?string $border = null)
    {
        $this->setWidth($width)
            ->setPadding(1);
        if ($border) {
            $this->setBorder($border);
        }
    }

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
    public function setBorderColor(?string $color)
    {
        $this->borderColor = $color;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getBorderColor(): ?string
    {
        return $this->borderColor;
    }

    /**
     * @inheritDoc
     */
    public function setHeaderColor(?string $color)
    {
        $this->headerColor = $color;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getHeaderColor(): ?string
    {
        return $this->headerColor;
    }

    /**
     * @inheritDoc
     */
    public function setHeaderBackgroundColor(?string $color)
    {
        $this->headerBackgroundColor = $color;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getHeaderBackgroundColor(): ?string
    {
        return $this->headerBackgroundColor;
    }
}
