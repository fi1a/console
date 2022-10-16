<?php

declare(strict_types=1);

namespace Fi1a\Console\Definition;

use Fi1a\Validation\AllOf;
use Fi1a\Validation\ChainInterface;
use Fi1a\Validation\OneOf;

/**
 * Валидация аргументов и опций
 */
interface ValidationInterface
{
    /**
     * Все правила должны удовлетворять условию
     */
    public function allOf(): AllOf;

    /**
     * Одно из правил должно удовлетворять условию
     */
    public function oneOf(): OneOf;

    /**
     * Возвращает цепочку правил проверки значения
     */
    public function getChain(): ?ChainInterface;
}
