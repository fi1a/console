<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\TreeComponent;

/**
 * Интерфейс оформления линии дерева
 */
interface LineInterface
{
    /**
     * Возвращает вертикальную линию
     */
    public function getVerticalLine(): string;

    /**
     * Возвращает конец линии
     */
    public function getEndLine(): string;

    /**
     * Возвращает середину линии
     */
    public function getMiddleLine(): string;
}
