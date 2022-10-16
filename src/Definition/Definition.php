<?php

declare(strict_types=1);

namespace Fi1a\Console\Definition;

use Fi1a\Console\Definition\Exception\DefinitionException;
use Fi1a\Console\IO\InputArgumentsInterface;
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
     * @inheritDoc
     */
    public function parseValues(InputArgumentsInterface $input): void
    {
        $tokens = $input->getTokens();

        $this->parseOptions($tokens);
        $this->parseShortOptions($tokens);
        if (($name = $this->checkUnknownOptions($tokens)) !== true) {
            throw new DefinitionException(sprintf('Передана неизвестная опция "%s"', $name));
        }
        $this->parseArguments($tokens);
        if (count($tokens)) {
            throw new DefinitionException('Передан неизвестный аргумент');
        }
    }

    /**
     * Парсим опции
     *
     * <code>
     * --option=1 --option=1,2,3
     * </code>
     *
     * @param string[] $tokens
     */
    private function parseOptions(array &$tokens): void
    {
        $tokens = array_values($tokens);
        foreach ($tokens as $ind => $token) {
            if (mb_substr($token, 0, 2) !== '--') {
                continue;
            }
            $token = mb_substr($token, 2);
            $explode = explode('=', $token);
            if (count($explode) === 1) {
                $explode[] = true;
            }
            /**
             * @var string $name
             */
            [$name, $value] = $explode;
            if (($option = $this->getOption($name)) === false) {
                continue;
            }
            unset($tokens[$ind]);
            if ($option->isMultiple()) {
                $value = array_map('trim', explode(',', (string) $value));
            }
            $option->setValue($value);
        }
    }

    /**
     * Парсим опции в короткой нотации
     *
     * <code>
     * -option 1 -option 1,2,3
     * </code>
     *
     * @param string[] $tokens
     */
    private function parseShortOptions(array &$tokens): void
    {
        $tokens = array_values($tokens);
        $count = count($tokens);
        foreach ($tokens as $ind => $token) {
            if (mb_substr($token, 0, 2) === '--' || mb_substr($token, 0, 1) !== '-') {
                continue;
            }
            $name = mb_substr($token, 1);
            if (($option = $this->getShortOption($name)) === false) {
                continue;
            }
            $value = null;
            if ($ind + 1 < $count) {
                $token = $tokens[$ind + 1];
                if (mb_substr($token, 0, 1) !== '-') {
                    $value = $token;
                    unset($tokens[$ind + 1]);
                }
            }
            unset($tokens[$ind]);
            if ($option->isMultiple()) {
                $value = array_map('trim', explode(',', (string) $value));
            }
            $option->setValue($value);
        }
    }

    /**
     * Парсим аргументы
     *
     * @param string[] $tokens
     */
    private function parseArguments(array &$tokens): void
    {
        $tokens = array_values($tokens);
        $arguments = $this->allArguments();
        $ind = 0;
        $count = count($tokens);
        $countArgs = count($arguments);
        foreach (array_values($arguments) as $aInd => $argument) {
            if ($ind >= $count) {
                break;
            }

            if (!$argument->isMultiple()) {
                $value = $tokens[$ind];
                unset($tokens[$ind]);
                $ind++;
                $argument->setValue($value);

                continue;
            }
            $value = [];
            while ($ind < $count && $countArgs - $aInd <= $count - $ind) {
                $value[] = $tokens[$ind];
                unset($tokens[$ind]);
                $ind++;
            }
            $argument->setValue($value);
        }
    }

    /**
     * Проверяет наличие не известных опций
     *
     * @param string[] $tokens
     *
     * @return true|string
     */
    private function checkUnknownOptions(array $tokens)
    {
        foreach ($tokens as $token) {
            if (mb_substr($token, 0, 2) === '--') {
                $token = mb_substr($token, 2);
            } elseif (mb_substr($token, 0, 1) === '-') {
                $token = mb_substr($token, 1);
            } else {
                continue;
            }
            [$name,] = explode('=', $token);

            return $name;
        }

        return true;
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
