<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\PanelComponent;

use Fi1a\Console\Component\ComponentInterface;
use Fi1a\Console\IO\ConsoleOutputInterface;

/**
 * Вывод текста в панели
 */
interface PanelComponentInterface extends ComponentInterface
{
    /**
     * Конструктор
     *
     * @param string|ComponentInterface|string[]|ComponentInterface[] $text
     */
    public function __construct(ConsoleOutputInterface $output, $text, PanelStyleInterface $style);

    /**
     * Получить текст
     *
     * @return string[]|ComponentInterface[]
     */
    public function getText(): array;

    /**
     * Установить текст
     *
     * @param string|ComponentInterface|string[]|ComponentInterface[] $text
     */
    public function setText($text): bool;

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
    public function setStyle(PanelStyleInterface $style): bool;

    /**
     * Вернуть стиль
     */
    public function getStyle(): PanelStyleInterface;
}
