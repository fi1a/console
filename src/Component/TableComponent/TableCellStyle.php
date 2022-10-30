<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\TableComponent;

use Fi1a\Console\Component\AlignTrait;
use Fi1a\Console\Component\PaddingTrait;
use Fi1a\Console\Component\WidthTrait;

/**
 * Стиль ячейки
 */
class TableCellStyle implements TableCellStyleInterface
{
    use AlignTrait;
    use WidthTrait;
    use PaddingTrait;

    /**
     * Конструктор
     */
    public function __construct(?int $width = null, ?string $align = null)
    {
        $this->setWidth($width)
            ->setAlign($align);
    }
}
