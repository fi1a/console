<?php

declare(strict_types=1);

namespace Fi1a\Console\IO;

use Fi1a\Console\Definition\ValidationInterface;

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

    /**
     * Множественное значение
     *
     * @return static
     */
    public function multiple(bool $multiple = true): EntityInterface;

    /**
     * Имеет ли множественное значение
     */
    public function isMultiple(): bool;

    /**
     * Валидация значений
     */
    public function validation(): ValidationInterface;

    /**
     * Валидация множественного значения
     */
    public function multipleValidation(): ValidationInterface;

    /**
     * Возвращает класс с цепочкой правил для проверки
     */
    public function getValidation(): ?ValidationInterface;

    /**
     * Возвращает класс с цепочкой правил для проверки
     */
    public function getMultipleValidation(): ?ValidationInterface;

    /**
     * Описание
     */
    public function description(string $description): EntityInterface;

    /**
     * Возвращает описание
     */
    public function getDescription(): ?string;
}
