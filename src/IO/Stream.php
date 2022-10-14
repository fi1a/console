<?php

declare(strict_types=1);

namespace Fi1a\Console\IO;

use InvalidArgumentException;

/**
 * Поток
 */
class Stream implements StreamInterface
{
    /**
     * @var resource|null
     */
    private $stream;

    /**
     * @inheritDoc
     */
    public function __construct($file = null, ?string $mode = null)
    {
        if (!$mode) {
            $mode = 'rw';
        }
        if ($file) {
            $this->open($file, $mode);
        }
    }

    /**
     * @inheritDoc
     */
    public function open($file, string $mode): bool
    {
        if (!$file) {
            return false;
        }
        if (!is_resource($file)) {
            $file = fopen($file, $mode);
        }

        $this->setStream($file);

        return true;
    }

    /**
     * @inheritDoc
     */
    public function close(): bool
    {
        $stream = $this->getStream();
        if (!$stream) {
            return false;
        }

        return fclose($stream);
    }

    /**
     * @inheritDoc
     */
    public function setStream($stream)
    {
        /** @psalm-suppress DocblockTypeContradiction */
        if (!is_resource($stream) || get_resource_type($stream) !== 'stream') {
            throw new InvalidArgumentException('Значение не является типом stream');
        }
        $this->stream = $stream;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getStream()
    {
        return $this->stream;
    }

    /**
     * @inheritDoc
     */
    public function write(string $content, ?int $length = null)
    {
        $stream = $this->getStream();

        if (!$stream) {
            return false;
        }

        return !is_null($length)
            ? fwrite($stream, $content, $length)
            : fwrite($stream, $content);
    }

    /**
     * @inheritDoc
     */
    public function read(int $length): string
    {
        $stream = $this->getStream();

        if (!$stream) {
            return '';
        }

        return fread($stream, $length);
    }

    /**
     * @inheritDoc
     */
    public function gets(?int $length = null)
    {
        $stream = $this->getStream();

        if (!$stream) {
            return false;
        }

        return !is_null($length) ? fgets($stream, $length) : fgets($stream);
    }

    /**
     * @inheritDoc
     */
    public function flush(): bool
    {
        $stream = $this->getStream();

        if (!$stream) {
            return false;
        }

        return fflush($stream);
    }

    /**
     * @inheritDoc
     */
    public function seek(int $offset): int
    {
        $stream = $this->getStream();

        if (!$stream) {
            return 0;
        }

        return fseek($stream, $offset);
    }
}
