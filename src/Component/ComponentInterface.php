<?php

declare(strict_types=1);

namespace Fi1a\Console\Component;

use Fi1a\Console\IO\AST\SymbolsInterface;

/**
 * Интерфейс компонента
 */
interface ComponentInterface
{
    /**
     * Отобразить компонент
     */
    public function display(): bool;

    /**
     * Возвращает коллекцию SymbolsInterface для вывода в консоль
     */
    public function getSymbols(RectangleInterface $rectangle): SymbolsInterface;
}
