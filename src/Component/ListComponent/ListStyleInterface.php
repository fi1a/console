<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\ListComponent;

use Fi1a\Console\Component\RectangleInterface;

/**
 * Стиль
 */
interface ListStyleInterface
{
    public const POSITION_INSIDE = 'inside';

    public const POSITION_OUTSIDE = 'outside';

    /**
     * В качестве маркера элементов списка выступает закрашенный кружок.
     */
    public const TYPE_DISC = 'disc';

    /**
     * В качестве маркера выступает незакрашенный кружок.
     */
    public const TYPE_CIRCLE = 'circle';

    /**
     * 1, 2, 3, 4, 5, …
     */
    public const TYPE_DECIMAL = 'decimal';

    /**
     * 01, 02, 03, 04, 05, …
     */
    public const TYPE_DECIMAL_LEADING_ZERO = 'decimal-leading-zero';

    /**
     * a, b, c, d, e, …
     */
    public const TYPE_LOWER_ALPHA = 'lower-alpha';

    /**
     * Маркер отсутствует
     */
    public const TYPE_NONE = 'none';

    /**
     * В качестве маркера выступает закрашенный квадрат.
     */
    public const TYPE_SQUARE = 'square';

    /**
     * A, B, C, D, E, …
     */
    public const TYPE_UPPER_ALPHA = 'upper-alpha';

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
     * Местоположение маркера списка
     *
     * @return $this
     */
    public function setPosition(string $position);

    /**
     * Местоположение маркера списка
     */
    public function getPosition(): string;

    /**
     * Тип маркера списка
     *
     * @return $this
     */
    public function setType(string $type);

    /**
     * Тип маркера списка
     */
    public function getType(): string;

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
     * Установить цвет маркера
     *
     * @return $this
     */
    public function setMarkerColor(?string $color);

    /**
     * Вернуть цвет маркера
     */
    public function getMarkerColor(): ?string;

    /**
     * Отступ между элементами списка
     *
     * @return $this
     */
    public function setMarginItem(?int $margin);

    /**
     * Отступ между элементами списка
     */
    public function getMarginItem(): ?int;
}
