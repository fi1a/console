<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\GroupComponent;

use Fi1a\Console\Component\AbstractComponent;
use Fi1a\Console\Component\ComponentInterface;
use Fi1a\Console\Component\OutputTrait;
use Fi1a\Console\Component\PanelComponent\PanelComponentInterface;
use Fi1a\Console\Component\Rectangle;
use Fi1a\Console\Component\RectangleInterface;
use Fi1a\Console\IO\AST\AST;
use Fi1a\Console\IO\AST\Grid;
use Fi1a\Console\IO\AST\Symbols;
use Fi1a\Console\IO\AST\SymbolsInterface;
use Fi1a\Console\IO\ConsoleOutputInterface;
use Fi1a\Console\IO\Style\ASTStyleConverter;
use InvalidArgumentException;

/**
 * Группа панелей
 */
class GroupComponent extends AbstractComponent implements GroupComponentInterface
{
    use OutputTrait;

    /**
     * @var GroupStyleInterface
     * @psalm-suppress PropertyNotSetInConstructor
     */
    private $style;

    /**
     * @var PanelComponentInterface[]
     */
    private $panels = [];

    /**
     * @inheritDoc
     */
    public function __construct(ConsoleOutputInterface $output, GroupStyleInterface $style, array $panels = [])
    {
        $this->setOutput($output);
        $this->setStyle($style);
        $this->setPanels($panels);
    }

    /**
     * @inheritDoc
     */
    public function setStyle(GroupStyleInterface $style): bool
    {
        $this->style = $style;

        return true;
    }

    /**
     * @inheritDoc
     */
    public function getStyle(): GroupStyleInterface
    {
        return $this->style;
    }

    /**
     * @inheritDoc
     */
    public function setPanels(array $panels): bool
    {
        foreach ($panels as $panel) {
            if (!$panel instanceof PanelComponentInterface) {
                throw new InvalidArgumentException(
                    'Объект должен реализовывать интерфейс ' . PanelComponentInterface::class
                );
            }
        }
        $this->panels = $panels;

        return true;
    }

    /**
     * @inheritDoc
     */
    public function getPanels(): array
    {
        return $this->panels;
    }

    /**
     * @inheritDoc
     */
    public function addPanel(PanelComponentInterface $panel): bool
    {
        $this->panels[] = $panel;

        return true;
    }

    /**
     * @inheritDoc
     */
    public function display(): bool
    {
        if (!count($this->getPanels())) {
            return true;
        }

        $rectangle = new Rectangle(
            $this->getStyle()->getWidth(),
            $this->getStyle()->getHeight()
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
        if (!count($this->getPanels())) {
            return $symbols;
        }
        $grid = new Grid($symbols);
        $height = $rectangle->getHeight();
        $panels = array_values($this->getPanels());
        if (!$height) {
            $heights = [1];
            foreach ($panels as $panel) {
                $panelGrid = new Grid();

                $width = (int) ($panel->getStyle()->getWidth()
                    ? $panel->getStyle()->getWidth()
                    : $rectangle->getWidth());
                $border = is_null($panel->getStyle()->getBorder()) ? 0 : 1;
                $textWidth = $width - (int) $panel->getStyle()->getPaddingLeft()
                    - (int) $panel->getStyle()->getPaddingRight() - (2 * $border);

                foreach ($panel->getText() as $text) {
                    if ($text instanceof ComponentInterface) {
                        $textRectangle = new Rectangle(
                            $textWidth,
                            null,
                            null,
                            null,
                            $panel->getStyle()->getAlign()
                        );
                        $panelGrid->appendBottom($text->getSymbols($textRectangle)->getArrayCopy());

                        continue;
                    }
                    $ast = new AST(
                        $text,
                        ASTStyleConverter::convertArray($this->getOutput()->getFormatter()::allStyles())
                    );
                    $panelGrid->appendBottom($ast->getSymbols()->getArrayCopy());
                    $panelGrid->wordWrap($textWidth);
                }

                $heights[] = $panelGrid->getHeight() + (int) $panel->getStyle()->getPaddingTop()
                    + (int) $panel->getStyle()->getPaddingBottom() + (($panel->getStyle()->getBorder() ? 1 : 0) * 2);
            }
            $height = max($heights);
        }

        $panelSpacing = $this->getStyle()->getPanelSpacing();
        foreach ($panels as $index => $panel) {
            $width = $panel->getStyle()->getWidth() ? $panel->getStyle()->getWidth() : $rectangle->getWidth();
            $panelRectangle = new Rectangle(
                $width,
                $height,
                null,
                null,
                $panel->getStyle()->getAlign()
            );
            if ($panelSpacing && $index < count($panels)) {
                $grid->wrapRight($panelSpacing, ' ');
            }
            $grid->appendRight($panel->getSymbols($panelRectangle)->getArrayCopy());
        }

        return $grid->getSymbols();
    }
}
