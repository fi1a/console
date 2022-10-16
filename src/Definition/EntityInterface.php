<?php

declare(strict_types=1);

namespace Fi1a\Console\Definition;

/**
 * Общая сущность опции и аргумента
 */
interface EntityInterface
{
    /**
     * Установить значение
     *
     * @param mixed $value
     *
     * @return static
     */
    public function setValue($value): EntityInterface;

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
    public function default($value): EntityInterface;
}
