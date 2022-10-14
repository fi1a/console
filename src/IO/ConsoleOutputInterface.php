<?php

declare(strict_types=1);

namespace Fi1a\Console\IO;

/**
 * Интерфейс вывода в консоль
 */
interface ConsoleOutputInterface extends OutputInterface
{
    /**
     * Устанавливает экземпляр класса вывода ошибок
     */
    public function setErrorOutput(OutputInterface $output): bool;

    /**
     * Возвращает экземпляр класса вывода ошибок
     */
    public function getErrorOutput(): OutputInterface;
}
