<?php

declare(strict_types=1);

namespace Fi1a\Console\IO;

use Fi1a\Console\IO\Formatter\FormatterInterface;

use const DIRECTORY_SEPARATOR;
use const PHP_EOL;

/**
 * Вывод в поток
 */
class StreamOutput extends AbstractOutput
{
    /**
     * @var StreamInterface
     * @psalm-suppress PropertyNotSetInConstructor
     */
    private $stream;

    /**
     * Конструктор
     */
    public function __construct(StreamInterface $stream, FormatterInterface $formatter, ?bool $decorated = null)
    {
        $this->setStream($stream);
        if (is_null($decorated)) {
            $decorated = $this->hasColorSupport();
        }

        parent::__construct($formatter, $decorated);
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
     * Определяет есть ли поддержка оформления вывода
     */
    protected function hasColorSupport(): bool
    {
        $stream = $this->stream->getStream();
        if (is_null($stream)) {
            return false;
        }

        if (DIRECTORY_SEPARATOR === '\\') {
            // @codeCoverageIgnoreStart
            return getenv('ANSICON') !== false || getenv('ConEmuANSI') === 'ON' || getenv('TERM') === 'xterm';
            // @codeCoverageIgnoreEnd
        }

        return function_exists('posix_isatty') && @posix_isatty($stream);
    }

    /**
     * @inheritDoc
     */
    protected function doWrite(string $message, bool $newLine): bool
    {
        $stream = $this->getStream();
        if ($stream->write($message . ($newLine ? PHP_EOL : '')) === false) {
            return false;
        }
        $stream->flush();

        return true;
    }
}
