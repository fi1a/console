<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\ListComponent;

/**
 * Интерфейс типа списка
 */
interface ListTypeInterface
{
    /**
     * Возвращает символ типа списка
     */
    public function getSymbol(int $index): string;
}
