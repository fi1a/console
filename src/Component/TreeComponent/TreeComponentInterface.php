<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\TreeComponent;

use Fi1a\Console\IO\ConsoleOutputInterface;

/**
 * Дерево
 */
interface TreeComponentInterface extends TreeNodeInterface
{
    /**
     * Конструктор
     */
    public function __construct(ConsoleOutputInterface $output);

    /**
     * Вернуть вывод
     */
    public function getOutput(): ConsoleOutputInterface;

    /**
     * Установить вывод
     */
    public function setOutput(ConsoleOutputInterface $output): bool;
}
