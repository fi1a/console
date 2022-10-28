<?php

declare(strict_types=1);

namespace Fi1a\Console\IO;

/**
 * Потоковый ввод
 */
class StreamInput implements InputInterface
{
    /**
     * @var StreamInterface
     * @psalm-suppress PropertyNotSetInConstructor
     */
    private $stream;

    /**
     * Конструктор
     */
    public function __construct(StreamInterface $stream)
    {
        $this->setStream($stream);
    }

    /**
     * @inheritDoc
     */
    public function read($default = null)
    {
        $value = $this->getStream()->gets();
        if (is_string($value)) {
            $value = trim($value);
        }

        if (!$value) {
            /**
             * @var mixed $value
             */
            $value = $default;
        }

        return $value;
    }

    /**
     * @inheritDoc
     */
    public function setStream(StreamInterface $stream): bool
    {
        $this->stream = $stream;

        return true;
    }

    /**
     * @inheritDoc
     */
    public function getStream(): StreamInterface
    {
        return $this->stream;
    }

    /**
     * @inheritDoc
     */
    public static function getEscapeSymbol(): string
    {
        return chr(27);
    }
}
