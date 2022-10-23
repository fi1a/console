<?php

declare(strict_types=1);

namespace Fi1a\Console\IO\Style;

use Fi1a\Console\IO\AST\Style;
use Fi1a\Console\IO\AST\StyleInterface as StyleInterfaceAST;

/**
 * Преобразует стили для AST
 */
class ASTStyleConverter
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
            $instance = static::convert($style);
            $instance->setStyleName((string) $name);
            $converted[$name] = $instance;
        }

        return $converted;
    }

    /**
     * Конвертирует стиль
     */
    public static function convert(StyleInterface $style): StyleInterfaceAST
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
}
