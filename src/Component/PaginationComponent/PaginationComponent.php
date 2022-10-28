<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\PaginationComponent;

use Fi1a\Console\Component\AbstractComponent;
use Fi1a\Console\Component\InputStreamTrait;
use Fi1a\Console\Component\OutputTrait;
use Fi1a\Console\Component\Rectangle;
use Fi1a\Console\Component\RectangleInterface;
use Fi1a\Console\IO\AST\AST;
use Fi1a\Console\IO\AST\Grid;
use Fi1a\Console\IO\AST\Style;
use Fi1a\Console\IO\AST\SymbolsInterface;
use Fi1a\Console\IO\ConsoleOutputInterface;
use Fi1a\Console\IO\InputInterface;
use Fi1a\Console\IO\Style\ASTStyleConverter;
use Fi1a\Format\Formatter;

use const PHP_EOL;

/**
 * Постраничная навигация
 */
class PaginationComponent extends AbstractComponent implements PaginationComponentInterface
{
    use OutputTrait;
    use InputStreamTrait;

    /**
     * @var int
     */
    private $pages = 0;

    /**
     * @var int
     */
    private $current = 1;

    /**
     * @var bool
     */
    private $valid = true;

    /**
     * @var PaginationStyleInterface
     * @psalm-suppress PropertyNotSetInConstructor
     */
    private $style;

    /**
     * @inheritDoc
     */
    public function __construct(ConsoleOutputInterface $output, InputInterface $stream, PaginationStyleInterface $style)
    {
        $this->setOutput($output);
        $this->setInputStream($stream);
        $this->setStyle($style);
    }

    /**
     * @inheritDoc
     */
    public function setStyle(PaginationStyleInterface $style): bool
    {
        $this->style = $style;

        return true;
    }

    /**
     * @inheritDoc
     */
    public function getStyle(): PaginationStyleInterface
    {
        return $this->style;
    }

    /**
     * @inheritDoc
     */
    public function getCount(): int
    {
        return $this->pages;
    }

    /**
     * @inheritDoc
     */
    public function setCount(int $pages): bool
    {
        $this->pages = $pages;

        return true;
    }

    /**
     * @inheritDoc
     */
    public function setCurrent(int $page): bool
    {
        if ($page > $this->getCount()) {
            $page = $this->getCount();
        }
        $this->current = $page;

        return true;
    }

    /**
     * @inheritDoc
     */
    public function getCurrent(): int
    {
        return $this->current;
    }

    /**
     * @inheritDoc
     */
    public function isValid(): bool
    {
        return $this->getCount() && $this->getValid();
    }

    /**
     * Устанавливает значение определяющее выход из цикла
     *
     * @return $this
     */
    private function setValid(bool $valid)
    {
        $this->valid = $valid;

        return $this;
    }

    /**
     * Возвращает значение определеяющее выход из цикла
     */
    private function getValid(): bool
    {
        return $this->valid;
    }

    /**
     * @inheritDoc
     */
    public function display(): bool
    {
        $input = $this->getInputStream();
        $current = $this->getCurrent();
        $symbols = $this->getSymbols(new Rectangle());
        $message = $this->getOutput()->getFormatter()->formatSymbols($symbols);
        $this->getOutput()->writeRaw($message);
        $value = (string) $input->read();
        if ($value === $input::getEscapeSymbol()) {
            $this->setValid(false);

            return true;
        }
        $value = trim(mb_strtolower($value));
        if ($value === 'n') {
            $current++;
            if ($current <= $this->getCount()) {
                $this->setCurrent($current);
            }

            return true;
        }
        if ($value === 'p') {
            $current--;
            if ($current >= 1) {
                $this->setCurrent($current);
            }

            return true;
        }
        $value = (int) $value;
        if ($value >= 1 && $value <= $this->getCount()) {
            $this->setCurrent($value);
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function getSymbols(RectangleInterface $rectangle): SymbolsInterface
    {
        $display = [];
        $current = $this->getCurrent();
        if ($current > 1) {
            $display[] = 'Пред.[p], ';
        }
        if ($current < $this->getCount()) {
            $display[] = 'След.[n], ';
        }
        $display[] = 'Выб.[номер], Выход[Esc]';
        $text = implode('', $display) . PHP_EOL . 'Страница {{current}} из {{count}}: ';
        $text = Formatter::format($text, ['current' => $this->getCurrent(), 'count' => $this->getCount()]);

        $ast = new AST(
            $text,
            ASTStyleConverter::convertArray($this->getOutput()->getFormatter()::allStyles())
        );
        $grid = new Grid($ast->getSymbols());

        if ($this->getStyle()->getColor() || $this->getStyle()->getBackgroundColor()) {
            $grid->appendStyles([new Style(
                null,
                $this->getStyle()->getColor(),
                $this->getStyle()->getBackgroundColor()
            ),
            ]);
        }

        return $grid->getSymbols();
    }
}
