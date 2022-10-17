<?php

declare(strict_types=1);

namespace Fi1a\Console\Definition;

use Fi1a\Validation\ResultInterface;

/**
 * Проверка значений опций и аргументов
 */
interface DefinitionValidatorInterface
{
    /**
     * Конструктор
     */
    public function __construct(DefinitionInterface $definition);

    /**
     * Метод валидации
     */
    public function validate(): ResultInterface;
}
