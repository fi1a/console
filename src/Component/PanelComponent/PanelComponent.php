<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\PanelComponent;

use Fi1a\Console\Component\AbstractComponent;
use Fi1a\Console\Component\Rectangle;
use Fi1a\Console\Component\RectangleInterface;
use Fi1a\Console\IO\AST\AST;
use Fi1a\Console\IO\AST\Grid;
use Fi1a\Console\IO\AST\SymbolsInterface;
use Fi1a\Console\IO\ConsoleOutputInterface;
use Fi1a\Console\IO\Style\StyleConverter;
use Fi1a\Console\IO\Style\TrueColorStyle;

/**
 * Вывод текста в панели
 */
class PanelComponent extends AbstractComponent implements PanelComponentInterface
{
    /**
     * @var ConsoleOutputInterface
     * @psalm-suppress PropertyNotSetInConstructor
     */
    private $output;

    /**
     * @var string
     */
    private $text = '';

    /**
     * @var PanelStyleInterface
     * @psalm-suppress PropertyNotSetInConstructor
     */
    private $style;

    /**
     * @inheritDoc
     */
    public function __construct(ConsoleOutputInterface $output, string $text, PanelStyleInterface $style)
    {
        $this->setOutput($output);
        $this->setText($text);
        $this->setStyle($style);
    }

    /**
     * @inheritDoc
     */
    public function getOutput(): ConsoleOutputInterface
    {
        return $this->output;
    }

    /**
     * @inheritDoc
     */
    public function setOutput(ConsoleOutputInterface $output): bool
    {
        $this->output = $output;

        return true;
    }

    /**
     * @inheritDoc
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @inheritDoc
     */
    public function setText(string $text): bool
    {
        $this->text = $text;

        return true;
    }

    /**
     * @inheritDoc
     */
    public function setStyle(PanelStyleInterface $style): bool
    {
        $this->style = $style;

        return true;
    }

    /**
     * @inheritDoc
     */
    public function getStyle(): PanelStyleInterface
    {
        return $this->style;
    }

    /**
     * @inheritDoc
     */
    public function display(): bool
    {
        $rectangle = new Rectangle(
            $this->getStyle()->getWidth(),
            $this->getStyle()->getHeight(),
            null,
            null,
            $this->getStyle()->getAlign()
        );

        $symbols = $this->getSymbols($rectangle);
        $message = $this->getOutput()->getFormatter()->formatAST($symbols);
        $this->getOutput()->writeRaw($message, true);

        return true;
    }

    /**
     * @inheritDoc
     */
    public function getSymbols(RectangleInterface $rectangle): SymbolsInterface
    {
        $align = $rectangle->getAlign();
        if (!$align) {
            $align = PanelStyleInterface::ALIGN_LEFT;
        }
        $isBorder = $this->getStyle()->getBorder() !== PanelStyleInterface::BORDER_NONE;
        $width = $rectangle->getWidth();
        $height = $rectangle->getHeight();

        $ast = new AST(
            $this->getText(),
            StyleConverter::convertArray($this->getOutput()->getFormatter()::allStyles())
        );
        $symbols = $ast->getSymbols();
        $grid = new Grid($symbols);

        if ($width) {
            $grid->wordWrap($this->getTextWidth($width));
            $grid->pad($this->getTextWidth($width), ' ', $align);
        }

        if ($height) {
            $textHeight = $this->getTextHeight($height);
            $gridHeight = $grid->getHeight();
            if ($gridHeight > $textHeight) {
                $grid->truncateHeight($textHeight);
            } elseif ($gridHeight < $textHeight && $width) {
                $textWidth = $this->getTextWidth($width) - 1;
                $grid->wrapBottom(
                    $textHeight - $gridHeight,
                    max($textWidth, 0),
                    ' '
                );
            }
        }

        if ($width) {
            $paddingLeft = $this->getStyle()->getPaddingLeft();
            if ($paddingLeft) {
                $grid->wrapLeft($paddingLeft, ' ');
            }
            $paddingRight = $this->getStyle()->getPaddingRight();
            if ($paddingRight) {
                $grid->wrapRight($paddingRight, ' ');
            }
            $paddingTop = $this->getStyle()->getPaddingTop();
            if ($paddingTop) {
                $grid->wrapTop(
                    $paddingTop,
                    $width - (2 * ($isBorder ? 1 : 0)) - 1,
                    ' '
                );
            }
            $paddingBottom = $this->getStyle()->getPaddingBottom();
            if ($paddingBottom) {
                $grid->wrapBottom(
                    $paddingBottom,
                    $width - (2 * ($isBorder ? 1 : 0)) - 1,
                    ' '
                );
            }
        }
        $backgroundColor = $this->getStyle()->getBackgroundColor();
        if ($backgroundColor) {
            $grid->prependStyles(
                [
                    StyleConverter::convertToAST(
                        new TrueColorStyle(null, $backgroundColor)
                    ),
                ]
            );
        }
        if ($width && $isBorder) {
            $styles = [];
            $leftBorderColor = $this->getStyle()->getLeftBorderColor();
            if ($leftBorderColor) {
                $styles[] = StyleConverter::convertToAST(new TrueColorStyle($leftBorderColor));
            }
            $grid->wrapLeft(1, $this->getBorderLeftRightSymbol(), $styles);
            $styles = [];
            $rightBorderColor = $this->getStyle()->getRightBorderColor();
            if ($rightBorderColor) {
                $styles[] = StyleConverter::convertToAST(new TrueColorStyle($rightBorderColor));
            }
            $grid->wrapRight(1, $this->getBorderLeftRightSymbol(), $styles);
            $styles = [];
            $topBorderColor = $this->getStyle()->getTopBorderColor();
            if ($this->getStyle()->getTopBorderColor()) {
                $styles[] = StyleConverter::convertToAST(new TrueColorStyle($topBorderColor));
            }
            $grid->wrapTop(
                1,
                $width - 1,
                $this->getBorderTopBottomSymbol(),
                $styles
            );
            $styles = [];
            $bottomBorderColor = $this->getStyle()->getBottomBorderColor();
            if ($bottomBorderColor) {
                $styles[] = StyleConverter::convertToAST(new TrueColorStyle($bottomBorderColor));
            }
            $grid->wrapBottom(
                1,
                $width - 1,
                $this->getBorderTopBottomSymbol(),
                $styles
            );
            $grid->set(1, 1, $this->getBorderTopLeft());
            $grid->set(1, $width - 1, $this->getBorderTopRight());
            $grid->set($grid->getHeight(), 1, $this->getBorderBottomLeft());
            $grid->set($grid->getHeight(), $width - 1, $this->getBorderBottomRight());
        }

        return $grid->getSymbols();
    }

    /**
     * Возвращает ширину текста
     */
    private function getTextWidth(int $width): int
    {
        $border = $this->getStyle()->getBorder() === PanelStyleInterface::BORDER_NONE  ? 0 : 1;
        $textWidth = $width - (int) $this->getStyle()->getPaddingLeft()
            - (int) $this->getStyle()->getPaddingRight() - (2 * $border);

        return max($textWidth, 0);
    }

    /**
     * Возвращает высоту текста
     */
    private function getTextHeight(int $height): int
    {
        $border = $this->getStyle()->getBorder() === PanelStyleInterface::BORDER_NONE  ? 0 : 1;
        $textHeight = $height - (int) $this->getStyle()->getPaddingTop()
            - (int) $this->getStyle()->getPaddingBottom() - (2 * $border);

        return max($textHeight, 0);
    }

    /**
     * Возвращает символ для левой и правой границы
     */
    private function getBorderLeftRightSymbol(): string
    {
        switch ($this->getStyle()->getBorder()) {
            case PanelStyleInterface::BORDER_HEAVY:
                return '┃';
            case PanelStyleInterface::BORDER_HORIZONTALS:
                return ' ';
            case PanelStyleInterface::BORDER_ROUNDED:
                return '│';
            case PanelStyleInterface::BORDER_DOUBLE:
                return '║';
            default:
                return '|';
        }
    }

    /**
     * Возвращает символ для левой и правой границы
     */
    private function getBorderTopBottomSymbol(): string
    {
        switch ($this->getStyle()->getBorder()) {
            case PanelStyleInterface::BORDER_HEAVY:
                return '━';
            case PanelStyleInterface::BORDER_ROUNDED:
            case PanelStyleInterface::BORDER_HORIZONTALS:
                return '─';
            case PanelStyleInterface::BORDER_DOUBLE:
                return '═';
            default:
                return '-';
        }
    }

    /**
     * Возвращает символ для верхнего левого угла
     */
    private function getBorderTopLeft(): string
    {
        switch ($this->getStyle()->getBorder()) {
            case PanelStyleInterface::BORDER_HEAVY:
                return '┏';
            case PanelStyleInterface::BORDER_HORIZONTALS:
                return ' ';
            case PanelStyleInterface::BORDER_ROUNDED:
                return '╭';
            case PanelStyleInterface::BORDER_DOUBLE:
                return '╔';
            default:
                return '+';
        }
    }

    /**
     * Возвращает символ для верхнего правого угла
     */
    private function getBorderTopRight(): string
    {
        switch ($this->getStyle()->getBorder()) {
            case PanelStyleInterface::BORDER_HEAVY:
                return '┓';
            case PanelStyleInterface::BORDER_HORIZONTALS:
                return ' ';
            case PanelStyleInterface::BORDER_ROUNDED:
                return '╮';
            case PanelStyleInterface::BORDER_DOUBLE:
                return '╗';
            default:
                return '+';
        }
    }

    /**
     * Возвращает символ для нижнего левого угла
     */
    private function getBorderBottomLeft(): string
    {
        switch ($this->getStyle()->getBorder()) {
            case PanelStyleInterface::BORDER_HEAVY:
                return '┗';
            case PanelStyleInterface::BORDER_HORIZONTALS:
                return ' ';
            case PanelStyleInterface::BORDER_ROUNDED:
                return '╰';
            case PanelStyleInterface::BORDER_DOUBLE:
                return '╚';
            default:
                return '+';
        }
    }

    /**
     * Возвращает символ для нижнего правого угла
     */
    private function getBorderBottomRight(): string
    {
        switch ($this->getStyle()->getBorder()) {
            case PanelStyleInterface::BORDER_HEAVY:
                return '┛';
            case PanelStyleInterface::BORDER_HORIZONTALS:
                return ' ';
            case PanelStyleInterface::BORDER_ROUNDED:
                return '╯';
            case PanelStyleInterface::BORDER_DOUBLE:
                return '╝';
            default:
                return '+';
        }
    }
}
