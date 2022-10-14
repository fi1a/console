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
     *
     * @param string|resource|null $file
     */
    public function __construct($file = null, ?string $mode = null);

    /**
     * Открыть поток
     *
     * @param string|resource $file
     */
    public function open($file, string $mode): bool;

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
     *
     * @return bool|int
     */
    public function write(string $content, ?int $length = null);

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
