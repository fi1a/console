<?php

declare(strict_types=1);

namespace Fi1a\Console\IO\AST;

/**
 * Символ
 */
class Symbol implements SymbolInterface
{
    /**
     * @var string
     * @psalm-suppress PropertyNotSetInConstructor
     */
    private $value;

    /**
     * @var StylesInterface
     * @psalm-suppress PropertyNotSetInConstructor
     */
    private $styles;

    /**
     * @inheritDoc
     */
    public function __construct(string $value, array $styles)
    {
        $this->setValue($value);
        $this->setStyles($styles);
    }

    /**
     * @inheritDoc
     */
    public function setValue(string $value): bool
    {
        $this->value = $value;

        return true;
    }

    /**
     * @inheritDoc
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @inheritDoc
     */
    public function setStyles(array $styles): bool
    {
        $this->styles = new Styles($styles);

        return true;
    }

    /**
     * @inheritDoc
     */
    public function getStyles(): StylesInterface
    {
        return $this->styles;
    }
}
