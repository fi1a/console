<?php

declare(strict_types=1);

namespace Fi1a\Console\IO;

use Fi1a\Console\Component\OutputTrait;

/**
 * Курсор
 */
class Cursor implements CursorInterface
{
    use OutputTrait;

    /**
     * @inheritDoc
     */
    public function __construct(ConsoleOutputInterface $output)
    {
        $this->setOutput($output);
    }

    /**
     * @inheritDoc
     */
    public function clear(): bool
    {
        $this->getOutput()->writeRaw("\x1b[2J");

        return true;
    }

    /**
     * @inheritDoc
     */
    public function bell(): bool
    {
        $this->getOutput()->writeRaw("\x07");

        return true;
    }

    /**
     * @inheritDoc
     */
    public function home(): bool
    {
        $this->getOutput()->writeRaw("\x1b[H");

        return true;
    }

    /**
     * @inheritDoc
     */
    public function move(int $x, int $y): bool
    {
        $out = '';
        $out .= $x > 0 ? "\x1b[{$x}D" : "\x1b[{$x}C";
        $out .= $y > 0 ? "\x1b[{$y}B" : "\x1b[{$y}A";

        $this->getOutput()->writeRaw($out);

        return true;
    }

    /**
     * @inheritDoc
     */
    public function moveTo(int $x, int $y): bool
    {
        $x++;
        $y++;
        $this->getOutput()->writeRaw("\x1b[{$x};{$y}H");

        return true;
    }

    /**
     * @inheritDoc
     */
    public function showCursor(): bool
    {
        $this->getOutput()->writeRaw("\x1b[?25h");

        return true;
    }

    /**
     * @inheritDoc
     */
    public function hideCursor(): bool
    {
        $this->getOutput()->writeRaw("\x1b[?25l");

        return true;
    }

    /**
     * @inheritDoc
     */
    public function setTitle(string $title): bool
    {
        $this->getOutput()->writeRaw("\x1b]0;{$title}\x07");

        return true;
    }
}
