<?php

declare(strict_types=1);

namespace Fi1a\Console\Definition;

use Fi1a\Validation\AllOf;
use Fi1a\Validation\ChainInterface;
use Fi1a\Validation\OneOf;

/**
 * Валидация аргументов и опций
 */
class Validation implements ValidationInterface
{
    /**
     * @var ChainInterface|null
     */
    private $chain;

    /**
     * @inheritDoc
     */
    public function allOf(): AllOf
    {
        /**
         * @var AllOf $chain
         */
        $chain = AllOf::create();

        return $this->chain = $chain;
    }

    /**
     * @inheritDoc
     */
    public function oneOf(): OneOf
    {
        /**
         * @var OneOf $chain
         */
        $chain = OneOf::create();

        return $this->chain = $chain;
    }

    /**
     * @inheritDoc
     */
    public function getChain(): ?ChainInterface
    {
        return $this->chain;
    }
}
