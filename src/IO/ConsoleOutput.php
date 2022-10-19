<?php

declare(strict_types=1);

namespace Fi1a\Console\IO;

use Fi1a\Console\IO\Formatter\FormatterInterface;

use const STDOUT;

/**
 * Вывод в консоль
 */
class ConsoleOutput extends StreamOutput implements ConsoleOutputInterface
{
    /**
     * @var OutputInterface
     * @psalm-suppress PropertyNotSetInConstructor
     */
    private $errorOutput;

    /**
     * Конструктор
     */
    public function __construct(FormatterInterface $formatter, ?bool $decorated = null)
    {
        $this->setErrorOutput(
            new StreamOutput(new Stream('php://stderr', 'w'), $formatter, $decorated)
        );
        $stream = new Stream();
        $stream->setStream(STDOUT);
        parent::__construct($stream, $formatter, $decorated);
    }

    /**
     * @inheritDoc
     */
    public function setErrorOutput(OutputInterface $output): bool
    {
        $this->errorOutput = $output;

        return true;
    }

    /**
     * @inheritDoc
     */
    public function getErrorOutput(): OutputInterface
    {
        return $this->errorOutput;
    }

    /**
     * @inheritDoc
     */
    public function setDecorated(bool $decorated): bool
    {
        parent::setDecorated($decorated);

        return $this->getErrorOutput()->setDecorated($decorated);
    }

    /**
     * @inheritDoc
     */
    public function setFormatter(FormatterInterface $formatter): bool
    {
        parent::setFormatter($formatter);

        return $this->getErrorOutput()->setFormatter($formatter);
    }

    /**
     * @inheritDoc
     */
    public function setVerbose(int $verbose): bool
    {
        parent::setVerbose($verbose);

        return $this->getErrorOutput()->setVerbose($verbose);
    }
}
