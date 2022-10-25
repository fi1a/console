<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\ListComponent;

use Fi1a\Console\Component\AlignTrait;
use Fi1a\Console\Component\WidthTrait;
use InvalidArgumentException;

/**
 * Стиль
 */
class ListStyle implements ListStyleInterface
{
    use WidthTrait;
    use AlignTrait;

    /**
     * @var string
     */
    private $position = self::POSITION_INSIDE;

    /**
     * @var string
     */
    private $type = self::TYPE_DISC;

    /**
     * @var string|null
     */
    private $markerColor;

    /**
     * @var int|null
     */
    private $marginItem;

    /**
     * Конструктор
     */
    public function __construct(?string $position = null, ?string $type = null, ?int $width = null)
    {
        if (!is_null($position)) {
            $this->setPosition($position);
        }
        if (!is_null($type)) {
            $this->setType($type);
        }
        if (!is_null($width)) {
            $this->setWidth($width);
        }
    }

    /**
     * @inheritDoc
     */
    public function setPosition(string $position)
    {
        $position = mb_strtolower($position);
        if (!in_array($position, [self::POSITION_INSIDE, self::POSITION_OUTSIDE])) {
            throw new InvalidArgumentException(
                sprintf('Неизвестное "%s" местоположение маркера списка', $position)
            );
        }
        if ($position === self::POSITION_OUTSIDE && is_null($this->getWidth())) {
            $this->setWidth(120);
        }
        $this->position = $position;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getPosition(): string
    {
        return $this->position;
    }

    /**
     * @inheritDoc
     */
    public function setType(string $type)
    {
        $type = mb_strtolower($type);
        if (
            !in_array(
                $type,
                [
                    self::TYPE_DISC, self::TYPE_CIRCLE, self::TYPE_DECIMAL, self::TYPE_DECIMAL_LEADING_ZERO,
                    self::TYPE_LOWER_ALPHA, self::TYPE_NONE, self::TYPE_SQUARE, self::TYPE_UPPER_ALPHA,
                ]
            )
        ) {
            throw new InvalidArgumentException(
                sprintf('Неизвестный "%s" тип маркера списка', $type)
            );
        }
        $this->type = $type;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @inheritDoc
     */
    public function setMarkerColor(?string $color)
    {
        $this->markerColor = $color;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getMarkerColor(): ?string
    {
        return $this->markerColor;
    }

    /**
     * @inheritDoc
     */
    public function setMarginItem(?int $margin)
    {
        if (!is_null($margin) && $margin < 0) {
            throw new \InvalidArgumentException('Отступ должен быть больше или равен нулю');
        }

        $this->marginItem = $margin;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getMarginItem(): ?int
    {
        return $this->marginItem;
    }
}
