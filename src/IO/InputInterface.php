<?php

declare(strict_types=1);

namespace Fi1a\Console\IO;

/**
 * Интерфейс ввода
 */
interface InputInterface
{
    /**
     * Чтение
     *
     * @param mixed $default
     *
     * @return mixed
     */
    public function read($default = null);

    /**
     * Устанавливает поток
     */
    public function setStream(StreamInterface $stream): bool;

    /**
     * Возвращает поток
     */
    public function getStream(): StreamInterface;
}
