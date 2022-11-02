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
     * @var string[]
     */
    private $success = [];

    /**
     * @inheritDoc
     */
    public function __construct(ConsoleOutputInterface $output, InputInterface $stream)
    {
        $this->setOutput($output);
        $this->setInput($stream);
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
            throw new InvalidArgumentException(sprintf('Значение "%s" уже добавлено', $name));
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
        $output = $this->getOutput();
        foreach ($this->allValues() as $name => $value) {
            assert(is_string($name));
            if (in_array($name, $this->success)) {
                continue;
            }
            $label = $name;
            $description = $value->getDescription();
            if ($description) {
                $label = $description;
            }
            $index = 1;
            if ($value->isMultiple()) {
                $output->writeln($label . ': ');
                $values = [];
                do {
                    $output->write($index . ') ');
                    $readValue = $this->readValue($value);
                    if ($readValue === StreamInput::getEscapeSymbol()) {
                        /** @psalm-suppress PossiblyNullReference */
                        if ($value->getMultipleValidation() && $value->getMultipleValidation()->getChain()) {
                            /** @psalm-suppress PossiblyNullReference */
                            $result = $value->getMultipleValidation()->getChain()->validate($values);
                            if (!$result->isSuccess()) {
                                $output->writeln($result->getErrors()->join('; '), [], 'error');

                                continue;
                            }
                        }

                        break;
                    }
                    $values[] = $readValue;
                    $index++;
                } while (true);
                $value->setValue($values);
                $this->success[] = $name;

                continue;
            }

            $output->write($label . ': ');
            $readValue = $this->readValue($value);
            $value->setValue($readValue);
            $this->success[] = $name;
        }

        return true;
    }

    /**
     * Чтение значения
     */
    private function readValue(InteractiveValue $value): ?string
    {
        $output = $this->getOutput();
        $input = $this->getInput();

        $read = true;
        $readValue = null;
        while ($read) {
            $readValue = (string) $input->read();
            if ($readValue === StreamInput::getEscapeSymbol()) {
                if ($value->isMultiple()) {
                    return $readValue;
                }
                $readValue = null;
            }
            /** @psalm-suppress PossiblyNullReference */
            if ($value->getValidation() && $value->getValidation()->getChain()) {
                /** @psalm-suppress PossiblyNullReference */
                $result = $value->getValidation()->getChain()->validate($readValue);
                if (!$result->isSuccess()) {
                    $output->writeln($result->getErrors()->join('; '), [], 'error');

                    continue;
                }
            }

            $read = false;
        }

        return $readValue;
    }

    /**
     * @inheritDoc
     */
    public function asArray(): array
    {
        $values = [];
        foreach ($this->allValues() as $name => $value) {
            /** @psalm-suppress MixedAssignment */
            $values[(string) $name] = $value->getValue();
        }

        return $values;
    }

    /**
     * @inheritDoc
     */
    public function refresh(): bool
    {
        $this->success = [];
        foreach ($this->allValues() as $value) {
            $value->setValue(null);
        }

        return true;
    }
}
