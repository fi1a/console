<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\TreeComponent;

use Fi1a\Console\Component\AbstractComponent;
use Fi1a\Console\Component\ComponentInterface;
use Fi1a\Console\Component\OutputTrait;
use Fi1a\Console\Component\PanelComponent\PanelComponent;
use Fi1a\Console\Component\PanelComponent\PanelStyle;
use Fi1a\Console\Component\Rectangle;
use Fi1a\Console\Component\RectangleInterface;
use Fi1a\Console\IO\AST\AST;
use Fi1a\Console\IO\AST\Grid;
use Fi1a\Console\IO\AST\Style;
use Fi1a\Console\IO\AST\Symbols;
use Fi1a\Console\IO\AST\SymbolsInterface;
use Fi1a\Console\IO\ConsoleOutputInterface;
use Fi1a\Console\IO\Style\ASTStyleConverter;

/**
 * Дерево
 */
class TreeComponent extends AbstractComponent implements TreeComponentInterface
{
    use TreeNodeTrait;
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
    public function display(): bool
    {
        if (!count($this->getNodes())) {
            return true;
        }

        $style = $this->getStyle();
        $rectangle = new Rectangle($style ? $style->getWidth() : null);

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
        if (!count($this->getNodes())) {
            return $symbols;
        }
        $grid = new Grid($symbols);
        $grid->appendBottom($this->getNodeSymbols($rectangle, $this->getNodes())->getArrayCopy());

        return $grid->getSymbols();
    }

    /**
     * Формирование узлов
     *
     * @param TreeNodeInterface[] $nodes
     */
    private function getNodeSymbols(
        RectangleInterface $rectangle,
        array $nodes,
        int $level = 0,
        ?TreeNodeInterface $parentNode = null
    ): SymbolsInterface {
        $symbols = new Symbols();
        $grid = new Grid($symbols);
        $nodes = array_values($nodes);
        foreach ($nodes as $index => $node) {
            assert($node instanceof TreeNodeInterface);
            $labelPanelStyle = new PanelStyle();
            $labelPanelStyle->setWidth($rectangle->getWidth());
            $labelPanel = new PanelComponent($this->getOutput(), $node->getTitle(), $labelPanelStyle);
            $labelPanelRectangle = new Rectangle($rectangle->getWidth());
            $labelPanelSymbols = $labelPanel->getSymbols($labelPanelRectangle);
            $labelPanelGrid = new Grid($labelPanelSymbols);

            foreach ($node->getText() as $text) {
                $nodeStyle = $node->getStyle();
                $width = $nodeStyle ? $nodeStyle->getWidth() : null;
                if ($text instanceof ComponentInterface) {
                    $textRectangle = new Rectangle($width);
                    $labelPanelGrid->appendBottom($text->getSymbols($textRectangle)->getArrayCopy());

                    continue;
                }
                $ast = new AST(
                    $text,
                    ASTStyleConverter::convertArray($this->getOutput()->getFormatter()::allStyles())
                );
                $textGrid = new Grid($ast->getSymbols());
                if ($width) {
                    $textGrid->wordWrap($width);
                    $textGrid->pad($width, ' ');
                }
                $labelPanelGrid->appendBottom($textGrid->getSymbols()->getArrayCopy());
            }

            if (count($node->getNodes())) {
                $labelPanelGrid->appendBottom(
                    $this->getNodeSymbols(
                        $rectangle,
                        $node->getNodes(),
                        $level + 1,
                        $node
                    )->getArrayCopy()
                );
            }

            if ($level > 0 && $parentNode) {
                $lineColorStyles = [];
                $parentNodeStyle = $parentNode->getStyle();
                if ($parentNodeStyle && $parentNodeStyle->getLineColor()) {
                    $lineColorStyles = [new Style(null, $parentNodeStyle->getLineColor())];
                }
                $labelPanelGrid->wrapLeft($level + 3, ' ');
                for ($line = 1; $line <= $labelPanelGrid->getHeight(); $line++) {
                    $labelPanelGrid->setValue(
                        $line,
                        $level,
                        $this->getVerticalLine($parentNode),
                        $lineColorStyles
                    );
                }
                if ($index === count($nodes) - 1 || count($nodes) === 1) {
                    $labelPanelGrid->setValue(
                        1,
                        $level,
                        $this->getEndLine($parentNode),
                        $lineColorStyles
                    );
                } else {
                    $labelPanelGrid->setValue(
                        1,
                        $level,
                        $this->getMiddleLine($parentNode),
                        $lineColorStyles
                    );
                }
            }

            $grid->appendBottom($labelPanelGrid->getSymbols()->getArrayCopy());
        }

        return $grid->getSymbols();
    }

    /**
     * Возвращает вертикальную линию в соответсвии с типом
     */
    private function getVerticalLine(TreeNodeInterface $parentNode): string
    {
        $lineType = null;
        $style = $parentNode->getStyle();
        if ($style) {
            $lineType = $style->getLineType();
        }

        switch ($lineType) {
            case TreeStyleInterface::LINE_DOUBLE:
                return '║';
            case TreeStyleInterface::LINE_HEAVY:
                return '┃';
            case TreeStyleInterface::LINE_ASCII:
                return '|';
            default:
                return '│';
        }
    }

    /**
     * Возвращает конец линии в соответсвии с типом
     */
    private function getEndLine(TreeNodeInterface $parentNode): string
    {
        $lineType = null;
        $style = $parentNode->getStyle();
        if ($style) {
            $lineType = $style->getLineType();
        }

        switch ($lineType) {
            case TreeStyleInterface::LINE_DOUBLE:
                return '╚══';
            case TreeStyleInterface::LINE_HEAVY:
                return '┗━━';
            case TreeStyleInterface::LINE_ASCII:
                return '`--';
            default:
                return '└──';
        }
    }

    /**
     * Возвращает середину линии в соответсвии с типом
     */
    private function getMiddleLine(TreeNodeInterface $parentNode): string
    {
        $lineType = null;
        $style = $parentNode->getStyle();
        if ($style) {
            $lineType = $style->getLineType();
        }

        switch ($lineType) {
            case TreeStyleInterface::LINE_DOUBLE:
                return '╠══';
            case TreeStyleInterface::LINE_HEAVY:
                return '┣━━';
            case TreeStyleInterface::LINE_ASCII:
                return '+--';
            default:
                return '├──';
        }
    }
}
