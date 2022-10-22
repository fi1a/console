<?php

declare(strict_types=1);

namespace Fi1a\Console\Component;

use InvalidArgumentException;

trait TopTrait
{
    /**
     * @var int|null
     */
    private $top;

    /**
     * Вернуть позицию сверху
     */
    public function getTop(): ?int
    {
        return $this->top;
    }

    /**
     * Установить позицию сверху
     *
     * @return $this
     */
    public function setTop(?int $top)
    {
        if (!is_null($top) && $top <= 0) {
            throw new InvalidArgumentException('Позиция сверху должна быть больше 0');
        }
        $this->top = $top;

        return $this;
    }
}
