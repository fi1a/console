<?php

declare(strict_types=1);

namespace Fi1a\Console\Component;

use InvalidArgumentException;

/**
 * Методы выравнивания
 */
trait AlignTrait
{
    /**
     * @var string|null
     */
    private $align;

    /**
     * Вернуть выравнивание
     */
    public function getAlign(): ?string
    {
        return $this->align;
    }

    /**
     * Установить выравнивание
     *
     * @return $this
     */
    public function setAlign(?string $align)
    {
        if (!is_null($align)) {
            $align = mb_strtolower($align);
            if (
                !in_array(
                    $align,
                    [RectangleInterface::ALIGN_CENTER, RectangleInterface::ALIGN_LEFT, RectangleInterface::ALIGN_RIGHT]
                )
            ) {
                throw new InvalidArgumentException(
                    sprintf('Ошибка в переданном значении "%s" выравнивания', $align)
                );
            }
        }

        $this->align = $align;

        return $this;
    }
}
