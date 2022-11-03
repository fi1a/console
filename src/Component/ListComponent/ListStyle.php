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
    private $position = self::POSITION_OUTSIDE;

    /**
     * @var string|null
     */
    private $type = 'disc';

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
        if (!$width) {
            $width = 120;
        }
        $this->setWidth($width);
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
    public function setType(?string $type)
    {
        if (!is_null($type) && !ListTypeRegistry::has($type)) {
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
    public function getType(): ?string
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
