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
    private $line = 'normal';

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
    public function setLine(string $line)
    {
        if (!LineRegistry::has($line)) {
            throw new InvalidArgumentException(sprintf('Неизвестное "%s" оформление линии', $line));
        }

        $this->line = $line;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getLine(): string
    {
        return $this->line;
    }
}
