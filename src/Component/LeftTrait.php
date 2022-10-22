<?php

declare(strict_types=1);

namespace Fi1a\Console\Component;

use InvalidArgumentException;

/**
 * Методы позиции слева
 */
trait LeftTrait
{
    /**
     * @var int|null
     */
    private $left;

    /**
     * Вернуть позицию слева
     */
    public function getLeft(): ?int
    {
        return $this->left;
    }

    /**
     * Установить позицию слева
     *
     * @return $this
     */
    public function setLeft(?int $left)
    {
        if (!is_null($left) && $left <= 0) {
            throw new InvalidArgumentException('Позиция слева должна быть больше 0');
        }
        $this->left = $left;

        return $this;
    }
}
