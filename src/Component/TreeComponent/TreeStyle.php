<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\TreeComponent;

use Fi1a\Console\Component\WidthTrait;
use InvalidArgumentException;

/**
 * Стиль
 */
class TreeStyle implements TreeStyleInterface
{
    use WidthTrait;

    /**
     * @var string|null
     */
    private $lineColor;

    /**
     * @var string
     */
    private $lineType = self::LINE_NORMAL;

    /**
     * @inheritDoc
     */
    public function setLineColor(?string $color)
    {
        $this->lineColor = $color;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getLineColor(): ?string
    {
        return $this->lineColor;
    }

    /**
     * @inheritDoc
     */
    public function setLineType(string $lineType)
    {
        $lineType =  mb_strtolower($lineType);
        if (
            !in_array(
                $lineType,
                [self::LINE_ASCII, self::LINE_DOUBLE, self::LINE_HEAVY, self::LINE_NORMAL]
            )
        ) {
            throw new InvalidArgumentException(sprintf('Неизвестный "%s" тип линии', $lineType));
        }

        $this->lineType = $lineType;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getLineType(): string
    {
        return $this->lineType;
    }
}
