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
     * @var bool
     */
    private $multiple = false;

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

    /**
     * @inheritDoc
     */
    public function multiple(bool $multiple = true): EntityInterface
    {
        $this->multiple = $multiple;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function isMultiple(): bool
    {
        return $this->multiple;
    }
}
