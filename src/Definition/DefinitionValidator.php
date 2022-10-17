<?php

declare(strict_types=1);

namespace Fi1a\Console\Definition;

use Fi1a\Validation\ResultInterface;
use Fi1a\Validation\Validator;

/**
 * Проверка значений опций и аргументов
 */
class DefinitionValidator implements DefinitionValidatorInterface
{
    /**
     * @var DefinitionInterface
     */
    private $definition;

    /**
     * @inheritDoc
     */
    public function __construct(DefinitionInterface $definition)
    {
        $this->definition = $definition;
    }

    /**
     * @inheritDoc
     */
    public function validate(): ResultInterface
    {
        $validator = new Validator();
        $values = [];
        $rules = [];
        foreach ($this->definition->allOptions() + $this->definition->allArguments() as $name => $entity) {
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
