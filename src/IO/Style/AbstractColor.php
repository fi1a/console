<?php

declare(strict_types=1);

namespace Fi1a\Console\IO\Style;

/**
 * Абстрактный класс цвета
 */
abstract class AbstractColor implements ColorInterface
{
    /**
     * @var string|null
     */
    private $colorValue;

    /**
     * @inheritDoc
     */
    public function __construct(?string $color = null)
    {
        if (is_null($color)) {
            $color = self::DEFAULT;
        }
        $this->setColorValue($color);
        $this->setColor($color);
    }

    /**
     * @inheritDoc
     */
    public function getColorValue(): ?string
    {
        return $this->colorValue;
    }

    /**
     * Установит значение цвета
     */
    protected function setColorValue(?string $color): bool
    {
        $this->colorValue = $color;

        return true;
    }
}
