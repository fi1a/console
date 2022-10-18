<?php

declare(strict_types=1);

namespace Fi1a\Console\IO;

use InvalidArgumentException;

/**
 * Интерактивный ввод
 */
class InteractiveInput implements InteractiveInputInterface
{
    /**
     * @var ConsoleOutputInterface
     * @psalm-suppress PropertyNotSetInConstructor
     */
    private $output;

    /**
     * @var InputInterface
     * @psalm-suppress PropertyNotSetInConstructor
     */
    private $input;

    /**
     * @var InteractiveValue[]
     */
    private $values = [];

    /**
     * @inheritDoc
     */
    public function __construct(ConsoleOutputInterface $output, InputInterface $input)
    {
        $this->setOutput($output);
        $this->setInput($input);
    }

    /**
     * @inheritDoc
     */
    public function setOutput(ConsoleOutputInterface $output): bool
    {
        $this->output = $output;

        return true;
    }

    /**
     * @inheritDoc
     */
    public function getOutput(): ConsoleOutputInterface
    {
        return $this->output;
    }

    /**
     * @inheritDoc
     */
    public function setInput(InputInterface $input): bool
    {
        $this->input = $input;

        return true;
    }

    /**
     * @inheritDoc
     */
    public function getInput(): InputInterface
    {
        return $this->input;
    }

    /**
     * @inheritDoc
     */
    public function addValue(string $name): InteractiveValue
    {
        if (!$name) {
            throw new InvalidArgumentException('Значение $name не может быть пустым');
        }
        if ($this->hasValue($name)) {
            throw new InvalidArgumentException(sprintf('Значение "%s" уже добавлена', $name));
        }

        $value = new InteractiveValue();

        $this->values[mb_strtolower($name)] = $value;

        return $value;
    }

    /**
     * @inheritDoc
     */
    public function hasValue(string $name): bool
    {
        return array_key_exists(mb_strtolower($name), $this->values);
    }

    /**
     * @inheritDoc
     */
    public function getValue(string $name)
    {
        if (!$this->hasValue($name)) {
            return false;
        }

        return $this->values[mb_strtolower($name)];
    }

    /**
     * @inheritDoc
     */
    public function deleteValue(string $name): bool
    {
        if (!$this->hasValue($name)) {
            return false;
        }
        unset($this->values[mb_strtolower($name)]);

        return true;
    }

    /**
     * @inheritDoc
     */
    public function allValues(): array
    {
        return $this->values;
    }

    /**
     * @inheritDoc
     */
    public function read(): bool
    {
        return true;
    }
}
