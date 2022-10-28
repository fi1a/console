<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\PaginationComponent;

/**
 * Стиль
 */
interface PaginationStyleInterface
{
    /**
     * Установить цвет
     *
     * @return $this
     */
    public function setColor(?string $color);

    /**
     * Вернуть цвет
     */
    public function getColor(): ?string;

    /**
     * Установить цвет фона
     *
     * @return $this
     */
    public function setBackgroundColor(?string $color);

    /**
     * Вернуть цвет фона
     */
    public function getBackgroundColor(): ?string;
}
