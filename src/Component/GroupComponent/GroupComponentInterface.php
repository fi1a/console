<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\GroupComponent;

use Fi1a\Console\Component\ComponentInterface;
use Fi1a\Console\Component\PanelComponent\PanelComponentInterface;
use Fi1a\Console\IO\ConsoleOutputInterface;

/**
 * Группа панелей
 */
interface GroupComponentInterface extends ComponentInterface
{
    /**
     * Конструктор
     *
     * @param PanelComponentInterface[] $panels
     */
    public function __construct(ConsoleOutputInterface $output, GroupStyleInterface $style, array $panels = []);

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
    public function setStyle(GroupStyleInterface $style): bool;

    /**
     * Вернуть стиль
     */
    public function getStyle(): GroupStyleInterface;

    /**
     * Установить панели
     *
     * @param PanelComponentInterface[] $panels
     */
    public function setPanels(array $panels): bool;

    /**
     * Вернуть панели
     *
     * @return PanelComponentInterface[]
     */
    public function getPanels(): array;

    /**
     * Добавить панель для вывода
     */
    public function addPanel(PanelComponentInterface $panel): bool;
}
