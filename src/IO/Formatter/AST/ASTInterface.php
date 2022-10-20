<?php

declare(strict_types=1);

namespace Fi1a\Console\IO\Formatter\AST;

/**
 * AST
 */
interface ASTInterface
{
    /**
     * Конструктор
     *
     * @param StyleInterface[]|null $styles
     */
    public function __construct(string $format, ?array $styles = [], ?StyleInterface $style = null);

    /**
     * Возвращает символы строки
     */
    public function getSymbols(): SymbolsInterface;
}
