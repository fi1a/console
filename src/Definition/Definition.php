<?php

declare(strict_types=1);

namespace Fi1a\Console\Definition;

use Fi1a\Console\Definition\Exception\UnknownOptionException;
use Fi1a\Console\IO\InputArgumentsInterface;
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
     * @inheritDoc
     */
    public function addOption(string $name, ?string $shortName = null): OptionInterface
    {
        if (!$name) {
            throw new InvalidArgumentException('Аргумент $name не может быть пустым');
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
    public function parseValues(InputArgumentsInterface $input): void
    {
        $tokens = $input->getTokens();

        $this->parseOptions($tokens);

        if (($name = $this->checkUnknownOptions($tokens)) !== true) {
            $exception = new UnknownOptionException();
            $exception->setName($name);

            throw $exception;
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
            $option->setValue($value);
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
            } else {
                continue;
            }
            [$name,] = explode('=', $token);

            return $name;
        }

        return true;
    }
}
