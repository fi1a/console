<?php

declare(strict_types=1);

namespace Fi1a\Console\IO\AST;

use Fi1a\Console\Component\RectangleInterface;

/**
 * Работа с символами используя линии и колонки
 */
interface GridInterface
{
    public const ALIGN_LEFT = RectangleInterface::ALIGN_LEFT;

    public const ALIGN_RIGHT = RectangleInterface::ALIGN_RIGHT;

    public const ALIGN_CENTER = RectangleInterface::ALIGN_CENTER;

    /**
     * Конструктор
     */
    public function __construct(?SymbolsInterface $symbols = null);

    /**
     * Установить символы
     */
    public function setSymbols(SymbolsInterface $symbols): bool;

    /**
     * Получить символы
     */
    public function getSymbols(): SymbolsInterface;

    /**
     * Перенос по ширине
     */
    public function wordWrap(int $width, ?int $left = null): bool;

    /**
     * Дополняет до заданной длины переданным символом
     */
    public function pad(int $width, string $paddingChar, string $align): bool;

    /**
     * Оборачивает в символы по количеству с двух сторон
     */
    public function wrap(int $count, string $wrapChar): bool;

    /**
     * Оборачивает в символы по количеству слева
     *
     * @param StyleInterface[]  $styles
     */
    public function wrapLeft(int $count, string $wrapChar, array $styles = []): bool;

    /**
     * Оборачивает в символы по количеству справа
     *
     * @param StyleInterface[] $styles
     */
    public function wrapRight(int $count, string $wrapChar, array $styles = []): bool;

    /**
     * Оборачивает в символы по количеству вверху
     *
     * @param StyleInterface[] $styles
     */
    public function wrapTop(int $count, int $width, string $wrapChar, array $styles = []): bool;

    /**
     * Оборачивает в символы по количеству внизу
     *
     * @param StyleInterface[] $styles
     */
    public function wrapBottom(int $count, int $width, string $wrapChar, array $styles = []): bool;

    /**
     * Установить значение
     *
     * @param StyleInterface[] $styles
     */
    public function setValue(int $line, int $column, string $value, array $styles = []): bool;

    /**
     * Возвращает высоту
     */
    public function getHeight(): int;

    /**
     * Добавить в начало стили
     *
     * @param StyleInterface[] $styles
     */
    public function prependStyles(array $styles): bool;

    /**
     * Добавить в конец стили
     *
     * @param StyleInterface[] $styles
     */
    public function appendStyles(array $styles): bool;

    /**
     * Обрезает по высоте
     */
    public function truncateHeight(int $height): bool;

    /**
     * Добавить справа
     *
     * @param SymbolInterface[] $rightSymbols
     */
    public function appendRight(array $rightSymbols): bool;

    /**
     * Добавить снизу
     *
     * @param SymbolInterface[] $bottomSymbols
     */
    public function appendBottom(array $bottomSymbols): bool;

    /**
     * Возвращает ширину линии
     */
    public function getWidth(int $line = 1): int;

    /**
     * Возвращает ширину максимальной линии
     */
    public function getMaxWidth(): int;

    /**
     * Возвращает склееный текст на основе символов
     */
    public function getImage(): string;
}
