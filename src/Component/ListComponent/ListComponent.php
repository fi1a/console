<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\ListComponent;

use Fi1a\Console\Component\AbstractComponent;
use Fi1a\Console\Component\ComponentInterface;
use Fi1a\Console\Component\OutputTrait;
use Fi1a\Console\Component\PanelComponent\PanelComponent;
use Fi1a\Console\Component\PanelComponent\PanelStyle;
use Fi1a\Console\Component\Rectangle;
use Fi1a\Console\Component\RectangleInterface;
use Fi1a\Console\IO\AST\Grid;
use Fi1a\Console\IO\AST\Style;
use Fi1a\Console\IO\AST\Symbols;
use Fi1a\Console\IO\AST\SymbolsInterface;
use Fi1a\Console\IO\ConsoleOutputInterface;

/**
 * Список
 */
class ListComponent extends AbstractComponent implements ListComponentInterface
{
    use OutputTrait;

    /**
     * @var ListStyleInterface
     * @psalm-suppress PropertyNotSetInConstructor
     */
    private $style;

    /**
     * @var string[][]|ComponentInterface[][]
     */
    private $items = [];

    /**
     * @inheritDoc
     */
    public function __construct(ConsoleOutputInterface $output, ListStyleInterface $style, array $items = [])
    {
        $this->setOutput($output);
        $this->setStyle($style);
        $this->setItems($items);
    }

    /**
     * @inheritDoc
     */
    public function setStyle(ListStyleInterface $style): bool
    {
        $this->style = $style;

        return true;
    }

    /**
     * @inheritDoc
     */
    public function getStyle(): ListStyleInterface
    {
        return $this->style;
    }

    /**
     * @inheritDoc
     */
    public function setItems(array $items): bool
    {
        $this->items = [];
        foreach ($items as $item) {
            $this->addItem($item);
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function addItem($text): bool
    {
        if (!is_array($text)) {
            $text = [$text];
        }
        $this->items[] = $text;

        return true;
    }

    /**
     * @inheritDoc
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @inheritDoc
     */
    public function display(): bool
    {
        if (!count($this->getItems())) {
            return true;
        }

        $rectangle = new Rectangle(
            $this->getStyle()->getWidth(),
            null,
            null,
            null,
            $this->getStyle()->getAlign(),
        );

        $symbols = $this->getSymbols($rectangle);
        $message = $this->getOutput()->getFormatter()->formatSymbols($symbols);
        $this->getOutput()->writeRaw($message, true);

        return true;
    }

    /**
     * @inheritDoc
     */
    public function getSymbols(RectangleInterface $rectangle): SymbolsInterface
    {
        $symbols = new Symbols();
        if (!count($this->getItems())) {
            return $symbols;
        }

        $grid = new Grid($symbols);
        /**
         * @var string[][]|ComponentInterface[][] $items
         */
        $items = array_values($this->getItems());

        $listTypeSymbolWidth = 0;
        if (
            $this->getStyle()->getPosition() === ListStyleInterface::POSITION_OUTSIDE
            && $this->getStyle()->getType() !== ListStyleInterface::TYPE_NONE
        ) {
            $listTypeSymbolWidths = [0];
            foreach (array_keys($items) as $index) {
                assert(is_int($index));
                $listTypeSymbolWidths[] = mb_strlen($this->getListTypeSymbol($index));
            }
            $listTypeSymbolWidth = max($listTypeSymbolWidths);
        }

        foreach ($items as $index => $item) {
            assert(is_int($index));
            if ($this->getStyle()->getPosition() === ListStyleInterface::POSITION_INSIDE) {
                if (is_string($item[0])) {
                    $item[0] = str_repeat(' ', mb_strlen($this->getListTypeSymbol($index)) + 1) . $item[0];
                } else {
                    array_unshift($item, str_repeat(' ', mb_strlen($this->getListTypeSymbol($index)) + 1));
                }
            }
            $panelStyle = new PanelStyle();
            $panelStyle->setWidth($rectangle->getWidth())
                ->setAlign($rectangle->getAlign())
                ->setPadding(0);
            if (
                $this->getStyle()->getPosition() === ListStyleInterface::POSITION_OUTSIDE
                && $this->getStyle()->getType() !== ListStyleInterface::TYPE_NONE
            ) {
                $panelStyle->setPaddingLeft($listTypeSymbolWidth + 1);
            }
            $panel = new PanelComponent($this->getOutput(), $item, $panelStyle);
            $panelRectangle = new Rectangle(
                $rectangle->getWidth(),
                null,
                null,
                null,
                $rectangle->getAlign()
            );
            $panelSymbols = $panel->getSymbols($panelRectangle);
            $panelGrid = new Grid($panelSymbols);
            if ($this->getStyle()->getType() !== ListStyleInterface::TYPE_NONE) {
                $panelGrid->setValue(
                    1,
                    1,
                    $this->getListTypeSymbol($index),
                    [
                        new Style(null, $this->getStyle()->getMarkerColor()),
                    ]
                );
            }
            $marginItem = $this->getStyle()->getMarginItem();
            if ($marginItem) {
                $panelGrid->wrapBottom($marginItem, $panelGrid->getWidth(1), ' ');
            }
            $grid->appendBottom($panelGrid->getSymbols()->getArrayCopy());
        }

        return $grid->getSymbols();
    }

    /**
     * Возвращает символ списка
     */
    private function getListTypeSymbol(int $index): string
    {
        switch ($this->getStyle()->getType()) {
            case ListStyleInterface::TYPE_UPPER_ALPHA:
                return $this->getAlphaListType($index);
            case ListStyleInterface::TYPE_SQUARE:
                return '□';
            case ListStyleInterface::TYPE_LOWER_ALPHA:
                return mb_strtolower($this->getAlphaListType($index));
            case ListStyleInterface::TYPE_DECIMAL_LEADING_ZERO:
                return ($index + 1 < 10 ? '0' : '') . ($index + 1) . '.';
            case ListStyleInterface::TYPE_DECIMAL:
                return ($index + 1) . '.';
            case ListStyleInterface::TYPE_CIRCLE:
                return '○';
            default:
                return '●';
        }
    }

    /**
     * Алфавитный список
     */
    private function getAlphaListType(int $index): string
    {
        $out = '';
        $to = (int) floor($index / 25);
        for ($dim = 0; $dim <= $to; $dim++) {
            if ($dim === $to) {
                $out .= chr(65 + ($index - $dim * 25));

                continue;
            }

            $out .= 'z';
        }

        $out .= '.';

        return $out;
    }
}
