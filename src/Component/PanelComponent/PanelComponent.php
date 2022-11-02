<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\PanelComponent;

use Fi1a\Console\Component\AbstractComponent;
use Fi1a\Console\Component\ComponentInterface;
use Fi1a\Console\Component\OutputTrait;
use Fi1a\Console\Component\Rectangle;
use Fi1a\Console\Component\RectangleInterface;
use Fi1a\Console\IO\AST\AST;
use Fi1a\Console\IO\AST\Grid;
use Fi1a\Console\IO\AST\SymbolsInterface;
use Fi1a\Console\IO\ConsoleOutputInterface;
use Fi1a\Console\IO\Style\ASTStyleConverter;
use Fi1a\Console\IO\Style\TrueColorStyle;

/**
 * Вывод текста в панели
 */
class PanelComponent extends AbstractComponent implements PanelComponentInterface
{
    use OutputTrait;

    /**
     * @var string[]|ComponentInterface[]
     */
    private $text = [];

    /**
     * @var PanelStyleInterface
     * @psalm-suppress PropertyNotSetInConstructor
     */
    private $style;

    /**
     * @inheritDoc
     */
    public function __construct(ConsoleOutputInterface $output, $text, PanelStyleInterface $style)
    {
        $this->setOutput($output);
        $this->setText($text);
        $this->setStyle($style);
    }

    /**
     * @inheritDoc
     */
    public function getText(): array
    {
        return $this->text;
    }

    /**
     * @inheritDoc
     */
    public function setText($text): bool
    {
        if (!is_array($text)) {
            $text = [$text];
        }

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
        $message = $this->getOutput()->getFormatter()->formatSymbols($symbols);
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

        if ($width) {
            foreach ($this->getText() as $text) {
                if ($text instanceof ComponentInterface) {
                    $textRectangle = new Rectangle(
                        $width ? $this->getTextWidth($width) : null,
                        null,
                        null,
                        null,
                        $rectangle->getAlign()
                    );
                    $calcGrid = new Grid($text->getSymbols($textRectangle));

                    if ($width < $calcGrid->getMaxWidth()) {
                        $width = $calcGrid->getMaxWidth()
                            + (int) $this->getStyle()->getPaddingLeft()
                            + (int) $this->getStyle()->getPaddingRight()
                            + ($isBorder ? 1 : 0);
                    }
                }
            }
        }

        $grid = new Grid();
        foreach ($this->getText() as $text) {
            if ($text instanceof ComponentInterface) {
                $textRectangle = new Rectangle(
                    $width ? $this->getTextWidth($width) : null,
                    null,
                    null,
                    null,
                    $rectangle->getAlign()
                );
                $grid->appendBottom($text->getSymbols($textRectangle)->getArrayCopy());

                continue;
            }
            $ast = new AST(
                $text,
                ASTStyleConverter::convertArray($this->getOutput()->getFormatter()::allStyles())
            );
            $textGrid = new Grid($ast->getSymbols());
            if ($width) {
                $textGrid->wordWrap($this->getTextWidth($width));
                $textGrid->pad($this->getTextWidth($width), ' ', $align);
            }
            $grid->appendBottom($textGrid->getSymbols()->getArrayCopy());
        }

        if ($height) {
            $textHeight = $this->getTextHeight($height);
            $gridHeight = $grid->getHeight();
            if ($gridHeight > $textHeight) {
                $grid->truncateHeight($textHeight);
            } elseif ($gridHeight < $textHeight && $width) {
                $textWidth = $this->getTextWidth($width);
                $grid->wrapBottom(
                    $textHeight - $gridHeight,
                    max($textWidth, 1),
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
                    $grid->getWidth(),
                    ' '
                );
            }
            $paddingBottom = $this->getStyle()->getPaddingBottom();
            if ($paddingBottom) {
                $grid->wrapBottom(
                    $paddingBottom,
                    $grid->getWidth(),
                    ' '
                );
            }
        }
        $backgroundColor = $this->getStyle()->getBackgroundColor();
        $color = $this->getStyle()->getColor();
        if ($backgroundColor || $color) {
            $grid->prependStyles(
                [
                    ASTStyleConverter::convert(
                        new TrueColorStyle($color, $backgroundColor)
                    ),
                ]
            );
        }
        if ($width && $isBorder) {
            $styles = [];
            $leftBorderColor = $this->getStyle()->getLeftBorderColor();
            if ($leftBorderColor) {
                $styles[] = ASTStyleConverter::convert(new TrueColorStyle($leftBorderColor));
            }
            $grid->wrapLeft(1, $this->getBorderLeftRightSymbol(), $styles);
            $styles = [];
            $rightBorderColor = $this->getStyle()->getRightBorderColor();
            if ($rightBorderColor) {
                $styles[] = ASTStyleConverter::convert(new TrueColorStyle($rightBorderColor));
            }
            $grid->wrapRight(1, $this->getBorderLeftRightSymbol(), $styles);
            $styles = [];
            $topBorderColor = $this->getStyle()->getTopBorderColor();
            if ($this->getStyle()->getTopBorderColor()) {
                $styles[] = ASTStyleConverter::convert(new TrueColorStyle($topBorderColor));
            }
            $grid->wrapTop(
                1,
                $grid->getWidth(),
                $this->getBorderTopBottomSymbol(),
                $styles
            );
            $styles = [];
            $bottomBorderColor = $this->getStyle()->getBottomBorderColor();
            if ($bottomBorderColor) {
                $styles[] = ASTStyleConverter::convert(new TrueColorStyle($bottomBorderColor));
            }
            $grid->wrapBottom(
                1,
                $grid->getWidth($grid->getHeight()),
                $this->getBorderTopBottomSymbol(),
                $styles
            );
            $grid->setValue(1, 1, $this->getBorderTopLeft());
            $grid->setValue(1, $grid->getWidth($grid->getHeight()), $this->getBorderTopRight());
            $grid->setValue($grid->getHeight(), 1, $this->getBorderBottomLeft());
            $grid->setValue(
                $grid->getHeight(),
                $grid->getWidth($grid->getHeight()),
                $this->getBorderBottomRight()
            );
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

        return max($textWidth, 1);
    }

    /**
     * Возвращает высоту текста
     */
    private function getTextHeight(int $height): int
    {
        $border = $this->getStyle()->getBorder() === PanelStyleInterface::BORDER_NONE  ? 0 : 1;
        $textHeight = $height - (int) $this->getStyle()->getPaddingTop()
            - (int) $this->getStyle()->getPaddingBottom() - (2 * $border);

        return max($textHeight, 1);
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
