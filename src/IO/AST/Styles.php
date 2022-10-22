<?php

declare(strict_types=1);

namespace Fi1a\Console\IO\AST;

use Fi1a\Collection\DataType\MapArrayObject;

/**
 * Коллекция стилей
 */
class Styles extends MapArrayObject implements StylesInterface
{
    /**
     * @var StyleInterface|null
     */
    private $cache;

    /**
     * @inheritDoc
     */
    public function getComputedStyle(): StyleInterface
    {
        if ($this->cache) {
            return $this->cache;
        }

        /**
         * @var StyleInterface $style
         */
        $style = $this->reduce(function (StyleInterface $style, StyleInterface $value): StyleInterface {
            if ($value->getColor() !== null) {
                $style->setColor($value->getColor() === false ? null : $value->getColor());
            }
            if ($value->getBackground() !== null) {
                $style->setBackground($value->getBackground() === false ? null : $value->getBackground());
            }
            if ($value->getOptions() !== null) {
                $style->setOptions($value->getOptions() === false ? null : $value->getOptions());
            }

            return $style;
        }, new Style());

        return $this->cache = $style;
    }

    /**
     * @inheritDoc
     */
    public function resetComputedStyleCache(): bool
    {
        $this->cache = null;

        return true;
    }
}
