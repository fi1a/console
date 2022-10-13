<?php

declare(strict_types=1);

namespace Fi1a\Console\IO;

/**
 * Интерфейс потока
 */
interface StreamInterface
{
    /**
     * Конструктор
     */
    public function __construct(?string $file = null, ?string $mode = null);

    /**
     * Открыть поток
     */
    public function open(string $file, string $mode): bool;

    /**
     * Закрыть поток
     */
    public function close(): bool;

    /**
     * Устанавливает поток
     *
     * @param resource $stream
     *
     * @return $this
     */
    public function setStream($stream);

    /**
     * Возвращает поток
     *
     * @return resource|null
     */
    public function getStream();

    /**
     * Запись в поток
     */
    public function write(string $content, ?int $length = null): int;

    /**
     * Чтение из потока
     */
    public function read(int $length): string;

    /**
     * Читает строку из потока
     *
     * @return string|bool
     */
    public function gets(?int $length = null);

    /**
     * Сбрасывает буферизированный поток
     */
    public function flush(): bool;

    /**
     * Смещение в указателе
     */
    public function seek(int $offset): int;
}
