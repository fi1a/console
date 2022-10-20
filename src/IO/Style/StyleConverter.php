<?php

declare(strict_types=1);

namespace Fi1a\Console\IO\Style;

use Fi1a\Console\IO\Formatter\AST\Style;
use Fi1a\Console\IO\Formatter\AST\StyleInterface as StyleInterfaceAST;

/**
 * Преобразует стили для AST
 */
class StyleConverter
{
    /**
     * Конвертирует массив стилей
     *
     * @param StyleInterface[] $styles
     *
     * @return StyleInterfaceAST[]
     */
    public static function convertArray(array $styles): array
    {
        $converted = [];
        foreach ($styles as $name => $style) {
            $instance = static::convertToAST($style);
            $instance->setStyleName((string) $name);
            $converted[$name] = $instance;
        }

        return $converted;
    }

    /**
     * Конвертирует стиль
     */
    public static function convertToAST(StyleInterface $style): StyleInterfaceAST
    {
        $instance = new Style();
        $instance->setColor(
            $style->getColor()->isDefault() ? null : $style->getColor()->getColorValue()
        );
        $instance->setBackground(
            $style->getBackground()->isDefault() ? null : $style->getBackground()->getColorValue()
        );
        $options = null;
        foreach ($style->getOptions() as $option) {
            assert($option instanceof OptionInterface);
            if (!is_array($options)) {
                $options = [];
            }
            $options[] = $option::getName();
        }
        $instance->setOptions($options);

        return $instance;
    }

    /**
     * Конвертирует стиль
     */
    public static function convertFromAST(StyleInterfaceAST $styleAST, StyleInterface $style): StyleInterface
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
