<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\TableComponent;

/**
 * Стиль таблицы
 */
interface TableStyleInterface
{
    /**
     * Вернуть границы
     */
    public function getBorder(): string;

    /**
     * Установить границы
     *
     * @return $this
     */
    public function setBorder(string $border);

    /**
     * Установить ширину
     *
     * @return $this
     */
    public function setWidth(?int $width);

    /**
     * Вернуть ширину
     */
    public function getWidth(): ?int;

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
     * Установить цвет шапки
     *
     * @return $this
     */
    public function setHeaderColor(?string $color);

    /**
     * Вернуть цвет шапки
     */
    public function getHeaderColor(): ?string;

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
     * Установить цвет фона шапки
     *
     * @return $this
     */
    public function setHeaderBackgroundColor(?string $color);

    /**
     * Вернуть цвет фона шапки
     */
    public function getHeaderBackgroundColor(): ?string;

    /**
     * Установить цвет границ
     *
     * @return $this
     */
    public function setBorderColor(?string $color);

    /**
     * Вернуть цвет границ
     */
    public function getBorderColor(): ?string;

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
}
