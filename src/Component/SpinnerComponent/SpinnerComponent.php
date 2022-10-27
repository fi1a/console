<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\SpinnerComponent;

use Fi1a\Console\Component\AbstractComponent;
use Fi1a\Console\Component\OutputTrait;
use Fi1a\Console\Component\Rectangle;
use Fi1a\Console\Component\RectangleInterface;
use Fi1a\Console\IO\AST\AST;
use Fi1a\Console\IO\AST\SymbolsInterface;
use Fi1a\Console\IO\ConsoleOutputInterface;
use Fi1a\Console\IO\Style\ASTStyleConverter;
use Fi1a\Format\Formatter;

/**
 * Спиннер
 */
class SpinnerComponent extends AbstractComponent implements SpinnerComponentInterface
{
    use OutputTrait;

    /**
     * @var int
     */
    private $frame = 0;

    /**
     * @var int
     */
    private $lastLength = 0;

    /**
     * @var int
     */
    private $lastTime = 0;

    /**
     * @var SpinnerStyleInterface
     * @psalm-suppress PropertyNotSetInConstructor
     */
    private $style;

    /**
     * @var string|null
     */
    private $title;

    /**
     * @inheritDoc
     */
    public function __construct(ConsoleOutputInterface $output, SpinnerStyleInterface $style)
    {
        $this->setOutput($output);
        $this->setStyle($style);
    }

    /**
     * @inheritDoc
     */
    public function display(): bool
    {
        if (!$this->isRedraw()) {
            return true;
        }
        $symbols = $this->getSymbols(new Rectangle());
        if ($this->lastLength) {
            $this->clear();
        }
        $message = $this->getOutput()->getFormatter()->formatSymbols($symbols);
        $this->lastLength = mb_strlen($message);
        $this->getOutput()->writeRaw($message);
        $this->lastTime = time();

        return true;
    }

    /**
     * @inheritDoc
     */
    public function isRedraw(): bool
    {
        return !$this->lastTime || time() - $this->lastTime >= 1;
    }

    /**
     * @inheritDoc
     */
    public function getSymbols(RectangleInterface $rectangle): SymbolsInterface
    {
        $spinner = SpinnerRegistry::get($this->getStyle()->getSpinner());
        $frames = $spinner->getFrames();

        $frame = $frames[$this->frame];
        $this->frame++;
        if ($this->frame >= count($frames)) {
            $this->frame = 0;
        }
        $template = $this->getStyle()->getTemplate();
        $template = Formatter::format($template, [
            'spinner' => $frame,
            'title' => $this->getTitle(),
        ]);

        $ast = new AST(
            $template,
            ASTStyleConverter::convertArray($this->getOutput()->getFormatter()::allStyles())
        );

        return $ast->getSymbols();
    }

    /**
     * @inheritDoc
     */
    public function clear(): bool
    {
        if (!$this->lastLength) {
            return true;
        }

        $output = $this->getOutput();

        $output->writeRaw("\x0D");
        $output->writeRaw(str_repeat(' ', $this->lastLength));
        $output->writeRaw("\x0D");
        $this->lastTime = 0;

        return true;
    }

    /**
     * @inheritDoc
     */
    public function setStyle(SpinnerStyleInterface $style): bool
    {
        $this->style = $style;

        return true;
    }

    /**
     * @inheritDoc
     */
    public function getStyle(): SpinnerStyleInterface
    {
        return $this->style;
    }

    /**
     * @inheritDoc
     */
    public function setTitle(?string $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }
}
