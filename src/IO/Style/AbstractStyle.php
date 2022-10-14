<?php

declare(strict_types=1);

namespace Fi1a\Console\IO\Style;

/**
 * Абстрактный класс стиля
 */
abstract class AbstractStyle implements StyleInterface
{
    /**
     * @var string
     */
    protected $color;

    /**
     * @var string
     */
    protected $background;

    /**
     * @var bool[]
     */
    protected $options = [];

    /**
     * @inheritDoc
     */
    public function __construct(?string $color = null, ?string $background = null, array $options = [])
    {
        if (is_null($color)) {
            $color = self::DEFAULT_COLOR;
        }
        if (is_null($background)) {
            $background = self::DEFAULT_BACKGROUND_COLOR;
        }
        $this->setColor($color);
        $this->setBackground($background);
        $this->setOptions($options);
    }

    /**
     * @inheritDoc
     */
    public function setColor(string $color): bool
    {
        $this->color = $color;

        return true;
    }

    /**
     * @inheritDoc
     */
    public function setBackground(string $background): bool
    {
        $this->background = $background;

        return true;
    }

    /**
     * @inheritDoc
     */
    public function setOption(string $option): bool
    {
        $this->options[$option] = true;

        return true;
    }

    /**
     * @inheritDoc
     */
    public function unsetOption(string $option): bool
    {
        if (array_key_exists($option, $this->options)) {
            unset($this->options[$option]);

            return true;
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    public function setOptions(array $options): bool
    {
        foreach ($options as $option) {
            $this->setOption($option);
        }

        return true;
    }
}
