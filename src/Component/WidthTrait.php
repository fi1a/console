<?php

declare(strict_types=1);

namespace Fi1a\Console\Component;

use InvalidArgumentException;

/**
 * Методы ширины
 */
trait WidthTrait
{
    /**
     * @var int|null
     */
    private $width;

    /**
     * Вернуть ширину
     */
    public function getWidth(): ?int
    {
        return $this->width;
    }

    /**
     * Установить ширину
     *
     * @return $this
     */
    public function setWidth(?int $width)
    {
        if (!is_null($width) && $width <= 0) {
            throw new InvalidArgumentException('Ширина должна быть больше 0');
        }

        $this->width = $width;

        return $this;
    }
}
