<?php

declare(strict_types=1);

namespace Fi1a\Console\IO\Formatter\AST;

use Fi1a\Collection\Collection;

/**
 * Коллекция стилей
 */
class Styles extends Collection implements StylesInterface
{
    /**
     * @inheritDoc
     */
    public function getComputedStyle(): StyleInterface
    {
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

        return $style;
    }
}
