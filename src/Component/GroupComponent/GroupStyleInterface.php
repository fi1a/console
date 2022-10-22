<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\GroupComponent;

/**
 * Стиль
 */
interface GroupStyleInterface
{
    /**
     * Установить расстояние между панелями
     *
     * @return $this
     */
    public function setPanelSpacing(?int $panelSpacing);

    /**
     * Вернуть расстояние между панелями
     */
    public function getPanelSpacing(): ?int;

    /**
     * Вернуть ширину
     */
    public function getWidth(): int;

    /**
     * Установить ширину
     *
     * @return $this
     */
    public function setWidth(int $width);

    /**
     * Вернуть высоту
     */
    public function getHeight(): ?int;

    /**
     * Установить высоту
     *
     * @return $this
     */
    public function setHeight(?int $height);
}
