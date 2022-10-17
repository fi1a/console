<?php

declare(strict_types=1);

namespace Fi1a\Console\Definition;

use Fi1a\Console\IO\InputArgumentsInterface;

/**
 * Устанавливает значения аргументам и опциям
 */
interface ValueSetterInterface
{
    /**
     * Конструктор
     */
    public function __construct(Definition $definition, InputArgumentsInterface $input);

    /**
     * Установить значения
     */
    public function setValues(): bool;
}
