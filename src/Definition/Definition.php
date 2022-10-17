<?php

declare(strict_types=1);

namespace Fi1a\Console\Definition;

use Fi1a\Validation\ResultInterface;
use Fi1a\Validation\Validator;
use InvalidArgumentException;

/**
 * Определение опций и аргументов
 */
class Definition implements DefinitionInterface
{
    /**
     * @var OptionInterface[]
     */
    private $options = [];

    /**
     * @var OptionInterface[]
     */
    private $shortOptions = [];

    /**
     * @var ArgumentInterface[]
     */
    private $arguments = [];

    /**
     * @inheritDoc
     */
    public function addOption(string $name, ?string $shortName = null): OptionInterface
    {
        if (!$name) {
            throw new InvalidArgumentException('Аргумент $name не может быть пустым');
        }
        if ($this->hasOption($name)) {
            throw new InvalidArgumentException(sprintf('Опция "%s" уже добавлена', $name));
        }
        if ($shortName && $this->hasShortOption($shortName)) {
            throw new InvalidArgumentException(sprintf('Опция в короткой нотации "%s" уже добавлена', $shortName));
        }
        $option = new Option();

        $this->options[mb_strtolower($name)] = $option;
        if ($shortName) {
            $this->shortOptions[mb_strtolower($shortName)] = $option;
        }

        return $option;
    }

    /**
     * @inheritDoc
     */
    public function hasOption(string $name): bool
    {
        return array_key_exists(mb_strtolower($name), $this->options);
    }

    /**
     * @inheritDoc
     */
    public function getOption(string $name)
    {
        if (!$this->hasOption($name)) {
            return false;
        }

        return $this->options[mb_strtolower($name)];
    }

    /**
     * @inheritDoc
     */
    public function deleteOption(string $name): bool
    {
        if (!$this->hasOption($name)) {
            return false;
        }
        unset($this->options[mb_strtolower($name)]);

        return true;
    }

    /**
     * @inheritDoc
     */
    public function allOptions(): array
    {
        return $this->options;
    }

    /**
     * @inheritDoc
     */
    public function hasShortOption(string $shortName): bool
    {
        return array_key_exists(mb_strtolower($shortName), $this->shortOptions);
    }

    /**
     * @inheritDoc
     */
    public function getShortOption(string $shortName)
    {
        if (!$this->hasShortOption($shortName)) {
            return false;
        }

        return $this->shortOptions[mb_strtolower($shortName)];
    }

    /**
     * @inheritDoc
     */
    public function deleteShortOption(string $shortName): bool
    {
        if (!$this->hasShortOption($shortName)) {
            return false;
        }
        unset($this->shortOptions[mb_strtolower($shortName)]);

        return true;
    }

    /**
     * @inheritDoc
     */
    public function allShortOptions(): array
    {
        return $this->shortOptions;
    }

    /**
     * @inheritDoc
     */
    public function addArgument(string $name): ArgumentInterface
    {
        if (!$name) {
            throw new InvalidArgumentException('Аргумент $name не может быть пустым');
        }
        if ($this->hasArgument($name)) {
            throw new InvalidArgumentException(sprintf('Аргумент "%s" уже добавлен', $name));
        }
        $argument = new Argument();
        $this->arguments[mb_strtolower($name)] = $argument;

        return $argument;
    }

    /**
     * @inheritDoc
     */
    public function hasArgument(string $name): bool
    {
        return array_key_exists(mb_strtolower($name), $this->arguments);
    }

    /**
     * @inheritDoc
     */
    public function getArgument(string $name)
    {
        if (!$this->hasArgument($name)) {
            return false;
        }

        return $this->arguments[mb_strtolower($name)];
    }

    /**
     * @inheritDoc
     */
    public function deleteArgument(string $name): bool
    {
        if (!$this->hasArgument($name)) {
            return false;
        }
        unset($this->arguments[mb_strtolower($name)]);

        return true;
    }

    /**
     * @inheritDoc
     */
    public function allArguments(): array
    {
        return $this->arguments;
    }

    /**
     * Валидация
     */
    public function validate(): ResultInterface
    {
        $validator = new Validator();
        $values = [];
        $rules = [];
        foreach ($this->allOptions() + $this->allArguments() as $name => $entity) {
            $validation = $entity->getValidation();
            if ($validation && ($chain = $validation->getChain())) {
                if (!is_null($entity->getValue())) {
                    /** @psalm-suppress MixedAssignment */
                    $values[(string) $name] = $entity->getValue();
                }
                /** @psalm-suppress MixedAssignment */
                $rules[(string) $name] = $chain;
            }
        }
        $validation = $validator->make($values, $rules);

        return $validation->validate();
    }
}
