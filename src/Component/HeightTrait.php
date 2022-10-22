<?php

declare(strict_types=1);

namespace Fi1a\Console\Component;

use InvalidArgumentException;

/**
 * Методы высоты
 */
trait HeightTrait
{
    /**
     * @var int|null
     */
    private $height;

    /**
     * Вернуть высоту
     */
    public function getHeight(): ?int
    {
        return $this->height;
    }

    /**
     * Установить высоту
     *
     * @return $this
     */
    public function setHeight(?int $height)
    {
        if (!is_null($height) && $height <= 0) {
            throw new InvalidArgumentException('Высота должна быть больше 0');
        }
        $this->height = $height;

        return $this;
    }
}
