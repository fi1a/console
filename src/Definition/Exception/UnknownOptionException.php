<?php

declare(strict_types=1);

namespace Fi1a\Console\Definition\Exception;

use LogicException;

/**
 * Исключение при отсутствии опции
 */
class UnknownOptionException extends LogicException
{
    /**
     * @var string|null
     */
    private $name;

    /**
     * Установить название опции
     */
    public function setName(string $name): bool
    {
        $this->name = $name;

        return true;
    }

    /**
     * Получить название опции
     */
    public function getName(): ?string
    {
        return $this->name;
    }
}
