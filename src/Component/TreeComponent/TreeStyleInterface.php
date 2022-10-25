<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\TreeComponent;

/**
 * Стиль
 */
interface TreeStyleInterface
{
    public const LINE_ASCII = 'ascii';

    public const LINE_NORMAL = 'double';

    public const LINE_HEAVY = 'heavy';

    public const LINE_DOUBLE = 'double';

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
    public function setLineType(string $lineType);

    /**
     * Вернуть тип линии
     */
    public function getLineType(): string;
}
