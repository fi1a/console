<?php

declare(strict_types=1);

namespace Fi1a\Console\IO\Style;

/**
 * Интерфейс оформления в консоле
 */
interface OptionInterface
{
    /**
     * Цифровой код опции
     */
    public function getCode(): string;
}
