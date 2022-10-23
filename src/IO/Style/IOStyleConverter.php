<?php

declare(strict_types=1);

namespace Fi1a\Console\IO\Style;

use Fi1a\Console\IO\AST\StyleInterface as StyleInterfaceAST;

/**
 * Преобразует стили
 */
class IOStyleConverter
{
    /**
     * Конвертирует стиль
     */
    public static function convert(StyleInterfaceAST $styleAST, StyleInterface $style): StyleInterface
    {
        $color = $styleAST->getColor();
        if ($color) {
            $style->setColor($color);
        }
        $background = $styleAST->getBackground();
        if ($background) {
            $style->setBackground($background);
        }
        $options = $styleAST->getOptions();
        if ($options) {
            $style->setOptions($options);
        }

        return $style;
    }
}
