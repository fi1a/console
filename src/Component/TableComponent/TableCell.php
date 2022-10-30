<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\TableComponent;

use Fi1a\Collection\DataType\ValueObject;

/**
 *  Ячейка
 */
class TableCell extends ValueObject implements TableCellInterface
{
    /**
     * @var string[]
     */
    protected $modelKeys = ['value', 'colspan', 'style'];

    /**
     * @inheritDoc
     */
    public function setColspan(?int $colspan)
    {
        if ($colspan < 1) {
            $colspan = 1;
        }
        $this->modelSet('colspan', $colspan);

        return $this;
    }

    /**
     * @inheritDoc
     * @psalm-suppress MixedInferredReturnType
     * @psalm-suppress MixedReturnStatement
     */
    public function getColspan(): int
    {
        return $this->modelGet('colspan');
    }

    /**
     * @inheritDoc
     */
    public function setValue($value)
    {
        if (is_null($value)) {
            $value = [];
        }
        if (!is_array($value)) {
            $value = [$value];
        }
        $this->modelSet('value', $value);

        return $this;
    }

    /**
     * @inheritDoc
     * @psalm-suppress MixedInferredReturnType
     * @psalm-suppress MixedReturnStatement
     */
    public function getValue()
    {
        return $this->modelGet('value');
    }

    /**
     * @inheritDoc
     */
    public function setStyle(?TableCellStyleInterface $style)
    {
        if (is_null($style)) {
            $style = new TableCellStyle();
        }
        $this->modelSet('style', $style);

        return $this;
    }

    /**
     * @inheritDoc
     * @psalm-suppress MixedInferredReturnType
     * @psalm-suppress MixedReturnStatement
     */
    public function getStyle(): TableCellStyleInterface
    {
        return $this->modelGet('style');
    }
}
