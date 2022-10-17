<?php

declare(strict_types=1);

namespace Fi1a\Console\Definition;

use Fi1a\Console\Definition\Exception\ValueSetterException;
use Fi1a\Console\IO\InputArgumentsInterface;

/**
 * Устанавливает значения аргументам и опциям
 */
class ValueSetter implements ValueSetterInterface
{
    /**
     * @var DefinitionInterface
     */
    private $definition;

    /**
     * @var InputArgumentsInterface
     */
    private $input;

    /**
     * @inheritDoc
     */
    public function __construct(DefinitionInterface $definition, InputArgumentsInterface $input)
    {
        $this->definition = $definition;
        $this->input = $input;
    }

    /**
     * @inheritDoc
     */
    public function setValues(): bool
    {
        $tokens = $this->input->getTokens();

        $this->parseOptions($tokens);
        $this->parseShortOptions($tokens);
        if (($name = $this->checkUnknownOptions($tokens)) !== true) {
            throw new ValueSetterException(sprintf('Передана неизвестная опция "%s"', $name));
        }
        $this->parseArguments($tokens);
        if (count($tokens)) {
            throw new ValueSetterException('Передан неизвестный аргумент');
        }

        return true;
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
            if (($option = $this->definition->getOption($name)) === false) {
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
            if (($option = $this->definition->getShortOption($name)) === false) {
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
        $arguments = $this->definition->allArguments();
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
}
