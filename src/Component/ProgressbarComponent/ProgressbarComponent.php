<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\ProgressbarComponent;

use Fi1a\Console\Component\AbstractComponent;
use Fi1a\Console\Component\OutputTrait;
use Fi1a\Console\Component\Rectangle;
use Fi1a\Console\Component\RectangleInterface;
use Fi1a\Console\IO\AST\AST;
use Fi1a\Console\IO\AST\SymbolsInterface;
use Fi1a\Console\IO\ConsoleOutputInterface;
use Fi1a\Console\IO\Formatter as FormatterConsole;
use Fi1a\Console\IO\Style\ASTStyleConverter;
use Fi1a\Format\Formatter;

use const STR_PAD_LEFT;

/**
 * Прогрессбар
 */
class ProgressbarComponent extends AbstractComponent implements ProgressbarComponentInterface
{
    use OutputTrait;

    /**
     * @var ProgressbarStyleInterface
     * @psalm-suppress PropertyNotSetInConstructor
     */
    private $style;

    /**
     * @var int
     */
    private $lastLength = 0;

    /**
     * @var int
     */
    private $max = 0;

    /**
     * @var int
     */
    private $step = 0;

    /**
     * @var float
     */
    private $percent = 0.0;

    /**
     * @var int
     */
    private $startTime = 0;

    /**
     * @var int
     */
    private $stepWidth = 1;

    /**
     * @var string|null
     */
    private $title;

    /**
     * @inheritDoc
     */
    public function __construct(ConsoleOutputInterface $output, ProgressbarStyleInterface $style, int $steps = 0)
    {
        $this->setOutput($output);
        $this->setStyle($style);
        $this->setStartTime(time());
        $this->setMaxSteps($steps);
    }

    /**
     * @inheritDoc
     */
    public function setStyle(ProgressbarStyleInterface $style): bool
    {
        $this->style = $style;

        return true;
    }

    /**
     * @inheritDoc
     */
    public function getStyle(): ProgressbarStyleInterface
    {
        return $this->style;
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

        return true;
    }

    /**
     * @inheritDoc
     */
    public function start(?int $steps = null)
    {
        $this->setStartTime(time());
        if (!is_null($steps)) {
            $this->setMaxSteps($steps);
        }
        $this->setProgress(0);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function finish()
    {
        if (!$this->getMaxSteps()) {
            $this->setMaxSteps($this->getProgress());
        }
        $this->setProgress($this->getMaxSteps());

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setMaxSteps(int $steps)
    {
        $this->stepWidth = $steps ? mb_strwidth((string) $steps) : 4;
        $this->max = $steps;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getMaxSteps(): int
    {
        return $this->max;
    }

    /**
     * Размер шага
     */
    private function getStepWidth(): int
    {
        return $this->stepWidth;
    }

    /**
     * Устанавливает время начала
     *
     * @return $this
     */
    private function setStartTime(int $time)
    {
        $this->startTime = $time;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getStartTime(): int
    {
        return $this->startTime;
    }

    /**
     * @inheritDoc
     */
    public function getProgress(): int
    {
        return $this->step;
    }

    /**
     * @inheritDoc
     */
    public function setProgress(int $step)
    {
        $max = $this->getMaxSteps();
        if ($max && $step > $max) {
            $this->setMaxSteps($max = $step);
        }
        $this->setProgressPercent($max ? (float) $step / $max : 0);
        $this->step = $step;
        $this->display();

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getProgressPercent(): float
    {
        return $this->percent;
    }

    /**
     * Устанавливает процент
     *
     * @return $this
     */
    private function setProgressPercent(float $percent)
    {
        $this->percent = $percent;

        return $this;
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

    /**
     * @inheritDoc
     */
    public function increment(int $step = 1)
    {
        return $this->setProgress($this->getProgress() + $step);
    }

    /**
     * @inheritDoc
     */
    public function display(): bool
    {
        $symbols = $this->getSymbols(new Rectangle());
        if ($this->lastLength) {
            $this->clear();
        }
        $message = $this->getOutput()->getFormatter()->formatSymbols($symbols);
        $this->lastLength = mb_strlen($message);
        $this->getOutput()->writeRaw($message);

        return true;
    }

    /**
     * @inheritDoc
     */
    public function getSymbols(RectangleInterface $rectangle): SymbolsInterface
    {
        $template = $this->getStyle()->getTemplate();
        $template = Formatter::format($template, [
            'bar' => $this->renderBar(),
            'elapsed' => $this->renderElapsed(),
            'remaining' => $this->renderRemaining(),
            'memory' => $this->renderMemory(),
            'current' => $this->renderCurrent(),
            'max' => $this->renderMax(),
            'percent' => $this->renderPercent(),
            'title' => $this->renderTitle(),
        ]);

        $ast = new AST(
            $template,
            ASTStyleConverter::convertArray($this->getOutput()->getFormatter()::allStyles())
        );

        return $ast->getSymbols();
    }

    /**
     * Прогрессбар
     */
    protected function renderBar(): string
    {
        $complete = (int) floor(
            $this->getMaxSteps() > 0
                ? $this->getProgressPercent() * $this->getStyle()->getWidth()
                : $this->getProgress() % $this->getStyle()->getWidth()
        );
        $display = str_repeat($this->getStyle()->getCharacter(), $complete);
        if ($complete < $this->getStyle()->getWidth()) {
            $empty = $this->getStyle()->getWidth() - $complete
                - mb_strlen(strip_tags($this->getStyle()->getProgressCharacter()));
            $display .= $this->getStyle()->getProgressCharacter()
                . str_repeat($this->getStyle()->getEmptyCharacter(), $empty);
        }

        return FormatterConsole::addSlashes($display);
    }

    /**
     * Время выполнения
     */
    protected function renderElapsed(): string
    {
        return FormatterConsole::addSlashes(Formatter::format('{{|time}}', [time() - $this->getStartTime()]));
    }

    /**
     * Оставшееся время
     */
    protected function renderRemaining(): string
    {
        if (!$this->getMaxSteps() || !$this->getProgress()) {
            return 'Неизвестно';
        }
        if ($this->getProgress() === $this->getMaxSteps()) {
            return 'Завершено';
        }

        $remaining = round((time() - $this->getStartTime())
                           / $this->getProgress() * ($this->getMaxSteps() - $this->getProgress()));

        return FormatterConsole::addSlashes(Formatter::format('{{|time}}', [$remaining]));
    }

    /**
     * Используемая память
     */
    protected function renderMemory(): int
    {
        return memory_get_usage(true);
    }

    /**
     * Текущий шаг
     */
    protected function renderCurrent(): string
    {
        return str_pad((string) $this->getProgress(), $this->getStepWidth(), ' ', STR_PAD_LEFT);
    }

    /**
     * Максимальный шаг
     */
    protected function renderMax(): string
    {
        return (string) $this->getMaxSteps();
    }

    /**
     * Процент
     */
    protected function renderPercent(): string
    {
        return (string) floor($this->getProgressPercent() * 100);
    }

    /**
     * Заголовок
     */
    protected function renderTitle(): ?string
    {
        return $this->getTitle();
    }
}
