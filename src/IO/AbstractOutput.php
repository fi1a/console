<?php

declare(strict_types=1);

namespace Fi1a\Console\IO;

/**
 * Абстрактный класс вывода
 */
abstract class AbstractOutput implements OutputInterface
{
    /**
     * Вывод
     */
    abstract protected function doWrite(string $message, bool $newLine): bool;

    /**
     * @var int
     */
    private $verbose = self::VERBOSE_NORMAL;

    /**
     * @var bool
     */
    private $decorated = true;

    /**
     * @var FormatterInterface
     * @psalm-suppress PropertyNotSetInConstructor
     */
    private $formatter;

    /**
     * Output constructor.
     */
    public function __construct(FormatterInterface $formatter, bool $decorated = false)
    {
        $this->setFormatter($formatter);
        $this->setDecorated($decorated);
    }

    /**
     * @inheritDoc
     */
    public function isDecorated(): bool
    {
        return $this->decorated;
    }

    /**
     * @inheritDoc
     */
    public function setDecorated(bool $decorated): bool
    {
        $this->decorated = $decorated;

        return true;
    }

    /**
     * @inheritDoc
     */
    public function getFormatter(): FormatterInterface
    {
        return $this->formatter;
    }

    /**
     * @inheritDoc
     */
    public function setFormatter(FormatterInterface $formatter): bool
    {
        $this->formatter = $formatter;

        return true;
    }

    /**
     * @inheritDoc
     */
    public function write($messages, bool $newLine = false, int $verbose = self::VERBOSE_NORMAL): bool
    {
        $this->checkVerbose($verbose);
        if ($verbose > $this->getVerbose()) {
            return true;
        }
        $messages = (array) $messages;
        $formatter = $this->getFormatter();
        $result = true;
        foreach ($messages as $message) {
            $message = $this->isDecorated() ? $formatter->format($message) : strip_tags($message);
            $result = $this->doWrite($message, $newLine) && $result;
        }

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function writeln($messages, int $verbose = self::VERBOSE_NORMAL): bool
    {
        return $this->write($messages, true, $verbose);
    }

    /**
     * @inheritDoc
     */
    public function setVerbose(int $verbose): bool
    {
        $this->checkVerbose($verbose);
        $this->verbose = $verbose;

        return true;
    }

    /**
     * Проверка аргумента
     */
    private function checkVerbose(int $verbose): void
    {
        if ($verbose < self::VERBOSE_NONE || $verbose > self::VERBOSE_DEBUG) {
            throw new \InvalidArgumentException(
                sprintf('Передано ошибочное значение "%d" в качестве аргумента', $verbose)
            );
        }
    }

    /**
     * @inheritDoc
     */
    public function getVerbose(): int
    {
        return $this->verbose;
    }
}
