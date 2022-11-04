<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\TreeComponent;

/**
 * Стиль
 */
interface TreeStyleInterface
{
    /**
     * Вернуть ширину
     */
    public function getWidth(): ?int;

    /**
     * Установить ширину
     *
     * @return $this
     */
    public function setWidth(?int $width);

    /**
     * Установить цвет линии
     *
     * @return $this
     */
    public function setLineColor(?string $color);

    /**
     * Вернуть цвет линии
     */
    public function getLineColor(): ?string;

    /**
     * Установить тип линии
     *
     * @return $this
     */
    public function setLine(string $line);

    /**
     * Вернуть тип линии
     */
    public function getLine(): string;
}
