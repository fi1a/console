<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\TableComponent;

/**
 * Оформление границ
 */
interface BorderInterface
{
    /**
     * Символ пересечения границ
     */
    public function getCrossing(): string;

    /**
     * Горизонтальная линия
     */
    public function getHBorder(): string;

    /**
     * Горизонтальная линия (шапки)
     */
    public function getHBorderHeader(): string;

    /**
     * Горизонтальная линия
     */
    public function getHBorderTop(): string;

    /**
     * Горизонтальная линия
     */
    public function getHBorderBottom(): string;

    /**
     * Вертикальная линия
     */
    public function getVBorder(): string;

    /**
     * Вертикальная линия (левая)
     */
    public function getVBorderLeft(): string;

    /**
     * Вертикальная линия (правая)
     */
    public function getVBorderRight(): string;

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

    /**
     * Символ пересечения границ (сверху)
     */
    public function getTopCrossing(): string;

    /**
     * Символ пересечения границ (слева)
     */
    public function getLeftCrossing(): string;

    /**
     * Символ пересечения границ (справа)
     */
    public function getRightCrossing(): string;

    /**
     * Символ пересечения границ (снизу)
     */
    public function getBottomCrossing(): string;
}
