<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\PanelComponent;

/**
 * Оформление границ
 */
interface BorderInterface
{
    /**
     * Горизонтальная линия
     */
    public function getHBorder(): string;

    /**
     * Вертикальная линия
     */
    public function getVBorder(): string;

    /**
     * Левый верхний угол
     */
    public function getLeftTopCorner(): string;

    /**
     * Правый верхний угол
     */
    public function getRightTopCorner(): string;

    /**
     * Левый нижний угол
     */
    public function getLeftBottomCorner(): string;

    /**
     * Правый нижний угол
     */
    public function getRightBottomCorner(): string;
}
