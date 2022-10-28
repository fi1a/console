<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\PaginationComponent;

/**
 * Стиль
 */
class PaginationStyle implements PaginationStyleInterface
{
    /**
     * @var string|null
     */
    private $color;

    /**
     * @var string|null
     */
    private $backgroundColor;

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
}
