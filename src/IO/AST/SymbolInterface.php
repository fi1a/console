<?php

declare(strict_types=1);

namespace Fi1a\Console\IO\AST;

/**
 * Символ
 */
interface SymbolInterface
{
    /**
     * Конструктор
     *
     * @param StyleInterface[]  $styles
     */
    public function __construct(string $value, array $styles);

    /**
     * Установить значение
     */
    public function setValue(string $value): bool;

    /**
     * Вернуть значение
     */
    public function getValue(): string;

    /**
     * Установить стили
     *
     * @param StyleInterface[] $styles
     */
    public function setStyles(array $styles): bool;

    /**
     * Вернуть стили
     */
    public function getStyles(): StylesInterface;
}
