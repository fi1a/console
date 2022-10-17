<?php

declare(strict_types=1);

namespace Fi1a\Console\IO;

/**
 * Абстрактный класс ввода
 */
abstract class AbstractInputArguments implements InputArgumentsInterface
{
    /**
     * @var string[]
     * @psalm-suppress PropertyNotSetInConstructor
     */
    private $tokens;

    /**
     * @inheritDoc
     */
    public function getTokens(): array
    {
        return $this->tokens;
    }

    /**
     * @inheritDoc
     */
    public function setTokens(array $tokens): bool
    {
        $this->tokens = $tokens;

        return true;
    }
}
