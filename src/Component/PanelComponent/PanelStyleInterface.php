<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\PanelComponent;

use Fi1a\Console\Component\RectangleInterface;

/**
 * Стиль
 */
interface PanelStyleInterface
{
    public const ALIGN_LEFT = RectangleInterface::ALIGN_LEFT;

    public const ALIGN_RIGHT = RectangleInterface::ALIGN_RIGHT;

    public const ALIGN_CENTER = RectangleInterface::ALIGN_CENTER;

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
     * Вернуть высоту
     */
    public function getHeight(): ?int;

    /**
     * Установить высоту
     *
     * @return $this
     */
    public function setHeight(?int $height);

    /**
     * Вернуть выравнивание
     */
    public function getAlign(): ?string;

    /**
     * Установить выравнивание
     *
     * @return $this
     */
    public function setAlign(?string $align);

    /**
     * Вернуть границы
     */
    public function getBorder(): ?string;

    /**
     * Установить границы
     *
     * @return $this
     */
    public function setBorder(?string $border);

    /**
     * Установить отступ
     *
     * @return $this
     */
    public function setPadding(?int $padding);

    /**
     * Установить отступ слева
     *
     * @return $this
     */
    public function setPaddingLeft(?int $padding);

    /**
     * Вернуть отступ слева
     */
    public function getPaddingLeft(): ?int;

    /**
     * Установить отступ сверху
     *
     * @return $this
     */
    public function setPaddingTop(?int $padding);

    /**
     * Вернуть отступ сверху
     */
    public function getPaddingTop(): ?int;

    /**
     * Установить отступ справа
     *
     * @return $this
     */
    public function setPaddingRight(?int $padding);

    /**
     * Вернуть отступ справа
     */
    public function getPaddingRight(): ?int;

    /**
     * Установить отступ снизу
     *
     * @return $this
     */
    public function setPaddingBottom(?int $padding);

    /**
     * Вернуть отступ снизу
     */
    public function getPaddingBottom(): ?int;

    /**
     * Установить цвет границы
     *
     * @return $this
     */
    public function setBorderColor(?string $color);

    /**
     * Установить цвет левой границы
     *
     * @return $this
     */
    public function setLeftBorderColor(?string $color);

    /**
     * Вернуть цвет левой границы
     */
    public function getLeftBorderColor(): ?string;

    /**
     * Установить цвет правой границы
     *
     * @return $this
     */
    public function setRightBorderColor(?string $color);

    /**
     * Вернуть цвет правой границы
     */
    public function getRightBorderColor(): ?string;

    /**
     * Установить цвет верхней границы
     *
     * @return $this
     */
    public function setTopBorderColor(?string $color);

    /**
     * Вернуть цвет верхней границы
     */
    public function getTopBorderColor(): ?string;

    /**
     * Установить цвет нижней границы
     *
     * @return $this
     */
    public function setBottomBorderColor(?string $color);

    /**
     * Вернуть цвет нижней границы
     */
    public function getBottomBorderColor(): ?string;

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
}
