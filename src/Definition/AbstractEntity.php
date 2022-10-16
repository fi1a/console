<?php

declare(strict_types=1);

namespace Fi1a\Console\Definition;

/**
 * Абстрактный класс сущности опции или аргумента
 */
abstract class AbstractEntity implements EntityInterface
{
    /**
     * @var mixed
     */
    private $value;

    /**
     * @var mixed
     */
    private $default;

    /**
     * @inheritDoc
     */
    public function setValue($value): EntityInterface
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getValue()
    {
        if (is_null($this->value)) {
            return $this->default;
        }

        return $this->value;
    }

    /**
     * @inheritDoc
     */
    public function default($value): EntityInterface
    {
        $this->default = $value;

        return $this;
    }
}
