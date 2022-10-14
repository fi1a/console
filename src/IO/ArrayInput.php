<?php

declare(strict_types=1);

namespace Fi1a\Console\IO;

/**
 * Ввод из массива
 */
class ArrayInput implements InputInterface
{
    /**
     * @var string[]
     */
    private $tokens;

    /**
     * Конструктор
     *
     * @param string[] $argv
     */
    public function __construct(array $argv)
    {
        $this->tokens = $argv;
    }

    /**
     * @inheritDoc
     */
    public function getTokens(): array
    {
        return $this->tokens;
    }
}
