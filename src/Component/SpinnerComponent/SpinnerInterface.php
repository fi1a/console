<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\SpinnerComponent;

/**
 * Спиннер
 */
interface SpinnerInterface
{
    /**
     * Возвращает "кадры" отрисовки спиннера
     *
     * @return string[]
     */
    public function getFrames(): array;
}
