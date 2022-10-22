<?php

declare(strict_types=1);

namespace Fi1a\Console\Component;

/**
 * Размер отображаемой области и выравнивание
 */
class Rectangle implements RectangleInterface
{
    use WidthTrait;
    use HeightTrait;
    use LeftTrait;
    use TopTrait;
    use AlignTrait;

    /**
     * @inheritDoc
     */
    public function __construct(
        ?int $width = null,
        ?int $height = null,
        ?int $left = null,
        ?int $top = null,
        ?string $align = null
    ) {
        if (!is_null($width)) {
            $this->setWidth($width);
        }
        if (!is_null($height)) {
            $this->setHeight($height);
        }
        if (!is_null($left)) {
            $this->setLeft($left);
        }
        if (!is_null($top)) {
            $this->setTop($top);
        }
        if (!is_null($align)) {
            $this->setAlign($align);
        }
    }
}
