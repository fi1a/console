<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\ProgressbarComponent;

use Fi1a\Console\Component\ComponentInterface;
use Fi1a\Console\IO\ConsoleOutputInterface;

/**
 * Прогрессбар
 */
interface ProgressbarComponentInterface extends ComponentInterface
{
    /**
     * Конструктор
     */
    public function __construct(ConsoleOutputInterface $output, ProgressbarStyleInterface $style, int $steps = 0);

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
    public function setStyle(ProgressbarStyleInterface $style): bool;

    /**
     * Вернуть стиль
     */
    public function getStyle(): ProgressbarStyleInterface;

    /**
     * Убрать прогрессбар
     */
    public function clear(): bool;

    /**
     * Начать
     *
     * @return $this
     */
    public function start(?int $steps = null);

    /**
     * Завершить
     *
     * @return $this
     */
    public function finish();

    /**
     * Установить максимальное кол-во шагов
     *
     * @return $this
     */
    public function setMaxSteps(int $steps);

    /**
     * Вернуть максимальное кол-во шагов
     */
    public function getMaxSteps(): int;

    /**
     * Вернуть время начала
     */
    public function getStartTime(): int;

    /**
     * Вернуть текущий прогресс
     */
    public function getProgress(): int;

    /**
     * Установить текущий прогресс
     *
     * @return $this
     */
    public function setProgress(int $step);

    /**
     * Вернуть текущий прогресс в процентах
     */
    public function getProgressPercent(): float;

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
     * Увеличить прогресс на определенный шаг
     *
     * @return $this
     */
    public function increment(int $step = 1);
}
