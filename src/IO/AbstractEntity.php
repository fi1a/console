<?php

declare(strict_types=1);

namespace Fi1a\Console\IO;

use Fi1a\Console\Definition\Validation;
use Fi1a\Console\Definition\ValidationInterface;

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
     * @var Validation|null
     */
    private $validation;

    /**
     * @var Validation|null
     */
    private $multipleValidation;

    /**
     * @var string|null
     */
    private $description;

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

    /**
     * @inheritDoc
     */
    public function validation(): ValidationInterface
    {
        return $this->validation = new Validation();
    }

    /**
     * @inheritDoc
     */
    public function multipleValidation(): ValidationInterface
    {
        $this->multiple();

        return $this->multipleValidation = new Validation();
    }

    /**
     * @inheritDoc
     */
    public function getValidation(): ?ValidationInterface
    {
        return $this->validation;
    }

    /**
     * @inheritDoc
     */
    public function getMultipleValidation(): ?ValidationInterface
    {
        return $this->multipleValidation;
    }

    /**
     * @inheritDoc
     */
    public function description(string $description): EntityInterface
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }
}
