<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\SpinnerComponent;

use Fi1a\Console\Component\ComponentInterface;
use Fi1a\Console\IO\ConsoleOutputInterface;

/**
 * Спиннер
 */
interface SpinnerComponentInterface extends ComponentInterface
{
    /**
     * Конструктор
     *
     * @param string|ComponentInterface|string[]|ComponentInterface[] $text
     */
    public function __construct(ConsoleOutputInterface $output, SpinnerStyleInterface $style);

    /**
     * Вернуть вывод
     */
    public function getOutput(): ConsoleOutputInterface;

    /**
     * Установить вывод
     */
    public function setOutput(ConsoleOutputInterface $output): bool;

    /**
     * Установить стиль
     */
    public function setStyle(SpinnerStyleInterface $style): bool;

    /**
     * Вернуть стиль
     */
    public function getStyle(): SpinnerStyleInterface;

    /**
     * Убрать спиннер
     */
    public function clear(): bool;

    /**
     * Установить заголовок
     *
     * @return $this
     */
    public function setTitle(?string $title);

    /**
     * Вернуть заголовок
     */
    public function getTitle(): ?string;

    /**
     * Нужна ли отрисовка
     */
    public function isRedraw(): bool;
}
