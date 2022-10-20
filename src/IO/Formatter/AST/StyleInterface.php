<?php

declare(strict_types=1);

namespace Fi1a\Console\IO\Formatter\AST;

/**
 * Стиль
 */
interface StyleInterface
{
    /**
     * Конструктор
     *
     * @param string[]|null  $options
     */
    public function __construct(
        ?string $styleName = null,
        ?string $color = null,
        ?string $background = null,
        ?array $options = []
    );

    /**
     * Название стиля
     */
    public function setStyleName(?string $className): bool;

    /**
     * Название стиля
     */
    public function getStyleName(): ?string;

    /**
     * Установить цвет
     *
     * @param string|false|null $color
     */
    public function setColor($color): bool;

    /**
     * Вернуть цвет
     *
     * @return string|false|null
     */
    public function getColor();

    /**
     * Установить цвет фона
     *
     * @param string|false|null $background
     */
    public function setBackground($background): bool;

    /**
     * Вернуть цвет фона
     *
     * @return string|false|null
     */
    public function getBackground();

    /**
     * Установить оформление
     *
     * @param string[]|false|null $options
     */
    public function setOptions($options): bool;

    /**
     * Вернуть оформление
     *
     * @return string[]|false|null
     */
    public function getOptions();
}
