<?php

declare(strict_types=1);

namespace Fi1a\Console\IO\AST;

/**
 * Стиль
 */
class Style implements StyleInterface
{
    /**
     * @var string|null
     */
    private $className;

    /**
     * @var string|false|null
     */
    private $color;

    /**
     * @var string|false|null
     */
    private $background;

    /**
     * @var string[]|false|null
     */
    private $options;

    /**
     * @inheritDoc
     */
    public function __construct(
        ?string $styleName = null,
        ?string $color = null,
        ?string $background = null,
        ?array $options = null
    ) {
        $this->setStyleName($styleName);
        $this->setColor($color);
        $this->setBackground($background);
        $this->setOptions($options);
    }

    /**
     * @inheritDoc
     */
    public function setStyleName(?string $className): bool
    {
        $this->className = $className;

        return true;
    }

    /**
     * @inheritDoc
     */
    public function getStyleName(): ?string
    {
        return $this->className;
    }

    /**
     * @inheritDoc
     */
    public function setColor($color): bool
    {
        $this->color = $color;

        return true;
    }

    /**
     * @inheritDoc
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @inheritDoc
     */
    public function setBackground($background): bool
    {
        $this->background = $background;

        return true;
    }

    /**
     * @inheritDoc
     */
    public function getBackground()
    {
        return $this->background;
    }

    /**
     * @inheritDoc
     */
    public function setOptions($options): bool
    {
        $this->options = $options;

        return true;
    }

    /**
     * @inheritDoc
     */
    public function getOptions()
    {
        return $this->options;
    }
}
