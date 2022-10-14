<?php

declare(strict_types=1);

namespace Fi1a\Console\IO\Style;

/**
 * Интерфейс стиля
 */
interface StyleInterface
{
    public const DEFAULT_COLOR = 'default';

    public const DEFAULT_BACKGROUND_COLOR = 'default';

    /**
     * Конструктор
     *
     * @param string[]  $options
     */
    public function __construct(?string $color = null, ?string $background = null, array $options = []);

    /**
     * Установить цвет
     */
    public function setColor(string $color): bool;

    /**
     * Вернуть цвет
     */
    public function getColor(): ColorInterface;

    /**
     * Установить фон
     */
    public function setBackground(string $background): bool;

    /**
     * Вернуть фон
     */
    public function getBackground(): ColorInterface;

    /**
     * Установить опцию
     */
    public function setOption(string $option): bool;

    /**
     * Удалить опцию
     */
    public function unsetOption(string $option): bool;

    /**
     * Установить опции
     *
     * @param string[] $options
     */
    public function setOptions(array $options): bool;

    /**
     * Вернуть опции
     *
     * @return OptionInterface[]
     */
    public function getOptions(): array;

    /**
     * Применить стиль к тексту
     */
    public function apply(string $message): string;
}
