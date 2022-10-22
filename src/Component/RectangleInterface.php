<?php

declare(strict_types=1);

namespace Fi1a\Console\Component;

/**
 * Размер отображаемой области и выравнивание
 */
interface RectangleInterface
{
    public const ALIGN_LEFT = 'left';

    public const ALIGN_RIGHT = 'right';

    public const ALIGN_CENTER = 'center';

    /**
     * Конструктор
     */
    public function __construct(
        ?int $width = null,
        ?int $height = null,
        ?int $left = null,
        ?int $top = null,
        ?string $align = null
    );

    /**
     * Вернуть ширину
     */
    public function getWidth(): ?int;

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
    public function setHeight(int $height);

    /**
     * Вернуть позицию слева
     */
    public function getLeft(): ?int;

    /**
     * Установить позицию слева
     *
     * @return $this
     */
    public function setLeft(int $left);

    /**
     * Вернуть позицию сверху
     */
    public function getTop(): ?int;

    /**
     * Установить позицию сверху
     *
     * @return $this
     */
    public function setTop(int $top);

    /**
     * Вернуть выравнивание
     */
    public function getAlign(): ?string;

    /**
     * Установить выравнивание
     *
     * @return $this
     */
    public function setAlign(string $align);
}
