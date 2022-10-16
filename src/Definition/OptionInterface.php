<?php

declare(strict_types=1);

namespace Fi1a\Console\Definition;

/**
 * Интерфейс опции
 */
interface OptionInterface
{
    /**
     * Установить значение
     *
     * @param mixed $value
     *
     * @return static
     */
    public function setValue($value): OptionInterface;

    /**
     * Получить значение
     *
     * @return mixed
     */
    public function getValue();

    /**
     * Установить значение по умолчанию
     *
     * @param mixed $value
     */
    public function default($value): OptionInterface;
}
