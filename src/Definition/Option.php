<?php

declare(strict_types=1);

namespace Fi1a\Console\Definition;

/**
 * Опция
 */
class Option implements OptionInterface
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
    public function setValue($value): OptionInterface
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
    public function default($value): OptionInterface
    {
        $this->default = $value;

        return $this;
    }
}
