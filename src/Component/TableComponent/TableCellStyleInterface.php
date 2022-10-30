<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\TableComponent;

use Fi1a\Console\Component\RectangleInterface;

/**
 * Стиль ячейки
 */
interface TableCellStyleInterface
{
    public const ALIGN_LEFT = RectangleInterface::ALIGN_LEFT;

    public const ALIGN_RIGHT = RectangleInterface::ALIGN_RIGHT;

    public const ALIGN_CENTER = RectangleInterface::ALIGN_CENTER;

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
