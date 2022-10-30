<?php

declare(strict_types=1);

namespace Fi1a\Console\Component;

/**
 * Отступы
 */
trait PaddingTrait
{
    /**
     * @var int|null
     */
    private $paddingLeft;

    /**
     * @var int|null
     */
    private $paddingRight;

    /**
     * @var int|null
     */
    private $paddingBottom;

    /**
     * @var int|null
     */
    private $paddingTop;

    /**
     * Установить отступ
     *
     * @return $this
     */
    public function setPadding(?int $padding)
    {
        $this->setPaddingLeft(is_null($padding) ? $padding : $padding * 3)
            ->setPaddingRight(is_null($padding) ? $padding : $padding * 3)
            ->setPaddingBottom($padding)
            ->setPaddingTop($padding);

        return $this;
    }

    /**
     * Установить отступ слева
     *
     * @return $this
     */
    public function setPaddingLeft(?int $padding)
    {
        $this->paddingLeft = $padding;

        return $this;
    }

    /**
     * Вернуть отступ слева
     */
    public function getPaddingLeft(): ?int
    {
        return $this->paddingLeft;
    }

    /**
     * Установить отступ сверху
     *
     * @return $this
     */
    public function setPaddingTop(?int $padding)
    {
        $this->paddingTop = $padding;

        return $this;
    }

    /**
     * Вернуть отступ сверху
     */
    public function getPaddingTop(): ?int
    {
        return $this->paddingTop;
    }

    /**
     * Установить отступ справа
     *
     * @return $this
     */
    public function setPaddingRight(?int $padding)
    {
        $this->paddingRight = $padding;

        return $this;
    }

    /**
     * Вернуть отступ справа
     */
    public function getPaddingRight(): ?int
    {
        return $this->paddingRight;
    }

    /**
     * Установить отступ снизу
     *
     * @return $this
     */
    public function setPaddingBottom(?int $padding)
    {
        $this->paddingBottom = $padding;

        return $this;
    }

    /**
     * Вернуть отступ снизу
     */
    public function getPaddingBottom(): ?int
    {
        return $this->paddingBottom;
    }
}
