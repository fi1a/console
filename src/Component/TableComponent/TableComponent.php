<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\TableComponent;

use Fi1a\Console\Component\AbstractComponent;
use Fi1a\Console\Component\ComponentInterface;
use Fi1a\Console\Component\OutputTrait;
use Fi1a\Console\Component\PanelComponent\PanelComponent;
use Fi1a\Console\Component\PanelComponent\PanelStyle;
use Fi1a\Console\Component\Rectangle;
use Fi1a\Console\Component\RectangleInterface;
use Fi1a\Console\IO\AST\Grid;
use Fi1a\Console\IO\AST\Style;
use Fi1a\Console\IO\AST\SymbolsInterface;
use Fi1a\Console\IO\ConsoleOutputInterface;

/**
 * Таблица
 */
class TableComponent extends AbstractComponent implements TableComponentInterface
{
    use OutputTrait;

    /**
     * @var TableStyleInterface
     * @psalm-suppress PropertyNotSetInConstructor
     */
    private $style;

    /**
     * @var TableCellInterface[][]
     */
    private $headers = [];

    /**
     * @var TableCellInterface[][]
     */
    private $rows = [];

    /**
     * @inheritDoc
     */
    public function __construct(ConsoleOutputInterface $output, TableStyleInterface $style)
    {
        $this->setOutput($output);
        $this->setStyle($style);
    }

    /**
     * @inheritDoc
     */
    public function setStyle(TableStyleInterface $style): bool
    {
        $this->style = $style;

        return true;
    }

    /**
     * @inheritDoc
     */
    public function getStyle(): TableStyleInterface
    {
        return $this->style;
    }

    /**
     * @inheritDoc
     */
    public function setHeaders($headers)
    {
        $headers = array_values($headers);
        if (!is_array($headers[0])) {
            $headers = [$headers,];
        }
        foreach ($headers as $index => $header) {
            /** @psalm-suppress InvalidArgument */
            $this->setHeader($index, $header);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @inheritDoc
     */
    public function setHeader(int $index, $header)
    {
        foreach ($header as $ind => $cell) {
            if ($cell instanceof TableCellInterface) {
                continue;
            }
            if (!is_array($cell)) {
                $cell = ['value' => $cell,];
            }
            $header[$ind] = new TableCell($cell);
        }
        /** @psalm-suppress InvalidPropertyAssignmentValue */
        $this->headers[$index] = $header;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getHeader(int $index)
    {
        if (!$this->hasHeader($index)) {
            return false;
        }

        return $this->headers[$index];
    }

    /**
     * @inheritDoc
     */
    public function countHeaders(): int
    {
        return count($this->headers);
    }

    /**
     * @inheritDoc
     */
    public function hasHeader(int $index): bool
    {
        return array_key_exists($index, $this->headers);
    }

    /**
     * @inheritDoc
     */
    public function setRows($rows)
    {
        $this->rows = [];

        return $this->addRows($rows);
    }

    /**
     * @inheritDoc
     */
    public function getRows(): array
    {
        return $this->rows;
    }

    /**
     * @inheritDoc
     */
    public function addRows(array $rows)
    {
        foreach ($rows as $row) {
            $this->addRow($row);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function addRow($row)
    {
        $this->setRow(count($this->rows), $row);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setRow(int $index, $row)
    {
        foreach ($row as $ind => $cell) {
            if ($cell instanceof TableCellInterface) {
                continue;
            }
            if (!is_array($cell)) {
                $cell = ['value' => $cell,];
            }
            $row[$ind] = new TableCell($cell);
        }
        /** @psalm-suppress InvalidPropertyAssignmentValue */
        $this->rows[$index] = $row;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRow(int $index)
    {
        if (!$this->hasRow($index)) {
            return false;
        }

        return $this->rows[$index];
    }

    /**
     * @inheritDoc
     */
    public function countRows(): int
    {
        return count($this->rows);
    }

    /**
     * @inheritDoc
     */
    public function hasRow(int $index): bool
    {
        return array_key_exists($index, $this->rows);
    }

    /**
     * @inheritDoc
     */
    public function display(): bool
    {
        $rectangle = new Rectangle();
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
        $grid = new Grid();

        $columnsCount = $this->getColumnsCount();
        $headers = $this->buildRows($this->getHeaders());
        $rows = $this->buildRows($this->getRows());
        $columnWidths = $this->calculateColumnsWidth(array_merge($headers, $rows), $columnsCount);

        foreach ($headers as $index => $header) {
            assert(is_int($index));
            $grid->appendBottom(
                $this->displayRow(
                    $header,
                    $columnsCount,
                    $columnWidths,
                    $headers,
                    $index,
                    true,
                    $index === 0,
                    !count($rows) && $index === count($headers) - 1
                )->getArrayCopy()
            );
        }
        foreach ($rows as $index => $row) {
            assert(is_int($index));
            $grid->appendBottom(
                $this->displayRow(
                    $row,
                    $columnsCount,
                    $columnWidths,
                    $rows,
                    $index,
                    false,
                    !count($headers) && $index === 0,
                    $index === count($rows) - 1
                )->getArrayCopy()
            );
        }

        return $grid->getSymbols();
    }

    /**
     * Отрисовка строки
     *
     * Пример: | 1 | Learn PHP | John Poul | 2007-05-21 |
     *
     * @param TableCellInterface[]  $row
     * @param TableCellInterface[][]  $rows
     * @param int[]  $columnWidths
     */
    private function displayRow(
        array $row,
        int $columnsCount,
        array $columnWidths,
        array $rows,
        int $rowIndex,
        bool $header = false,
        bool $firstRow = false,
        bool $lastRow = false
    ): SymbolsInterface {
        $grid = new Grid();

        $heights = [0];
        foreach ($this->getRowColumns($row, $columnsCount) as $column) {
            $panelGrid = new Grid($this->displayCell(
                $row,
                $column,
                $columnWidths,
                $header
            ));
            $heights[] = $panelGrid->getHeight();
        }
        $height = max($heights);

        foreach ($this->getRowColumns($row, $columnsCount) as $index => $column) {
            assert(is_int($index));
            $cell = $row[$column] ?? (new TableCell())->setValue(' ');
            $prevRowCell = $rows[$rowIndex - 1][$column] ?? (new TableCell())->setValue(' ');
            $prevRowCellNext = $rows[$rowIndex - 1][$column + 1] ?? (new TableCell())->setValue(' ');
            $borderStyles = [];
            if ($this->getStyle()->getBorderColor()) {
                $borderStyles = [new Style(
                    null,
                    $this->getStyle()->getBorderColor(),
                    $header
                        ? $this->getStyle()->getHeaderBackgroundColor()
                        : $this->getStyle()->getBackgroundColor()
                ),
                ];
            }

            $isHLine = $this->getBorder()->getHBorder() !== ' ';
            if ($header || $rowIndex === 0) {
                $isHLine = $this->getBorder()->getHBorderHeader() !== ' ';
            }

            $panelGrid = new Grid($this->displayCell(
                $row,
                $column,
                $columnWidths,
                $header,
                $height
            ));

            if ($index === 0) {
                $panelGrid->wrapLeft(1, $this->getBorder()->getVBorderLeft(), $borderStyles);
            }
            if ($index === $columnsCount - 1) {
                $panelGrid->wrapRight(1, $this->getBorder()->getVBorderRight(), $borderStyles);
            } else {
                $panelGrid->wrapRight(1, $this->getBorder()->getVBorder(), $borderStyles);
            }
            if ($firstRow) {
                $panelGrid->wrapTop(
                    1,
                    $panelGrid->getWidth(),
                    $this->getBorder()->getHBorderTop(),
                    $borderStyles
                );
            } else {
                if ($header || $rowIndex === 0) {
                    $panelGrid->wrapTop(
                        1,
                        $panelGrid->getWidth(),
                        $this->getBorder()->getHBorderHeader(),
                        $borderStyles
                    );
                } else {
                    $panelGrid->wrapTop(
                        1,
                        $panelGrid->getWidth(),
                        $this->getBorder()->getHBorder(),
                        $borderStyles
                    );
                }
                if ($cell->getColspan() > 1) {
                    $width = $columnWidths[$column] + ($header || $rowIndex === 0 ? 1 : 2);
                    $panelGrid->setValue(
                        1,
                        $width,
                        $isHLine ? $this->getBorder()->getBottomCrossing() : $this->getBorder()->getVBorder(),
                        $borderStyles
                    );
                    foreach (range($column + 1, $column + $prevRowCell->getColspan() - 1) as $next) {
                        $width += $columnWidths[$next] + 1;
                        $panelGrid->setValue(
                            1,
                            $width,
                            $isHLine ? $this->getBorder()->getBottomCrossing() : $this->getBorder()->getVBorder(),
                            $borderStyles
                        );
                    }
                }
            }
            if ($firstRow) {
                $panelGrid->setValue(
                    1,
                    $panelGrid->getWidth(),
                    $this->getBorder()->getTopCrossing(),
                    $borderStyles
                );
            } else {
                if (
                    $prevRowCell->getColspan() > 1
                    || (
                        $prevRowCell instanceof TableCellColspan
                        && $prevRowCellNext instanceof TableCellColspan
                    )
                ) {
                    $panelGrid->setValue(
                        1,
                        $panelGrid->getWidth(),
                        $isHLine ? $this->getBorder()->getTopCrossing() : $this->getBorder()->getVBorder(),
                        $borderStyles
                    );
                } else {
                    $panelGrid->setValue(
                        1,
                        $panelGrid->getWidth(),
                        $isHLine ? $this->getBorder()->getCrossing() : $this->getBorder()->getVBorder(),
                        $borderStyles
                    );
                }
            }
            if ($index + $cell->getColspan() - 1 === $columnsCount - 1) {
                if ($firstRow) {
                    $panelGrid->setValue(
                        1,
                        $panelGrid->getWidth(),
                        $this->getBorder()->getRightTopCorner(),
                        $borderStyles
                    );
                } else {
                    $panelGrid->setValue(
                        1,
                        $panelGrid->getWidth(),
                        $isHLine ? $this->getBorder()->getRightCrossing() : $this->getBorder()->getVBorder(),
                        $borderStyles
                    );
                }
            }
            if ($index === 0) {
                if ($firstRow) {
                    $panelGrid->setValue(1, 1, $this->getBorder()->getLeftTopCorner(), $borderStyles);
                } else {
                    $panelGrid->setValue(
                        1,
                        1,
                        $isHLine ? $this->getBorder()->getLeftCrossing() : $this->getBorder()->getVBorder(),
                        $borderStyles
                    );
                }
            }

            if ($lastRow) {
                $panelGrid->wrapBottom(
                    1,
                    $panelGrid->getWidth(),
                    $this->getBorder()->getHBorderBottom(),
                    $borderStyles
                );
                if ($index === $columnsCount - 1) {
                    $panelGrid->setValue(
                        $panelGrid->getHeight(),
                        $panelGrid->getWidth(),
                        $this->getBorder()->getRightBottomCorner(),
                        $borderStyles
                    );
                } else {
                    $panelGrid->setValue(
                        $panelGrid->getHeight(),
                        $panelGrid->getWidth(),
                        $this->getBorder()->getBottomCrossing(),
                        $borderStyles
                    );
                }
                if ($index === 0) {
                    $panelGrid->setValue(
                        $panelGrid->getHeight(),
                        1,
                        $this->getBorder()->getLeftBottomCorner(),
                        $borderStyles
                    );
                }
            }

            $grid->appendRight($panelGrid->getSymbols()->getArrayCopy());
        }

        return $grid->getSymbols();
    }

    /**
     * Отрисовывает ячейку с отступами
     *
     * @param TableCellInterface[]  $row
     * @param int[]  $columnWidths
     */
    private function displayCell(
        array $row,
        int $column,
        array $columnWidths,
        bool $header = false,
        ?int $height = null
    ): SymbolsInterface {
        $cell = $row[$column] ?? (new TableCell())->setValue(' ');
        $width = $columnWidths[$column];
        if ($cell->getColspan() > 1) {
            foreach (range($column + 1, $column + $cell->getColspan() - 1) as $next) {
                $width += $columnWidths[$next] + 1;
            }
        }

        $paddingLeft = $this->getStyle()->getPaddingLeft();
        if ($cell->getStyle()->getPaddingLeft()) {
            $paddingLeft = $cell->getStyle()->getPaddingLeft();
        }
        $paddingRight = $this->getStyle()->getPaddingRight();
        if ($cell->getStyle()->getPaddingRight()) {
            $paddingRight = $cell->getStyle()->getPaddingRight();
        }
        $paddingTop = $this->getStyle()->getPaddingTop();
        if ($cell->getStyle()->getPaddingTop()) {
            $paddingTop = $cell->getStyle()->getPaddingTop();
        }
        $paddingBottom = $this->getStyle()->getPaddingBottom();
        if ($cell->getStyle()->getPaddingBottom()) {
            $paddingBottom = $cell->getStyle()->getPaddingBottom();
        }

        $grid = new Grid();
        foreach ($cell->getValue() as $value) {
            if ($value instanceof ComponentInterface) {
                $textRectangle = new Rectangle(
                    $width,
                    null,
                    null,
                    null,
                    $cell->getStyle()->getAlign()
                );
                $grid->appendBottom($value->getSymbols($textRectangle)->getArrayCopy());

                continue;
            }
            $panelStyle = new PanelStyle();
            $panelStyle->setWidth($width)
                ->setAlign($cell->getStyle()->getAlign())
                ->setColor(
                    $header
                        ? $this->getStyle()->getHeaderColor()
                        : $this->getStyle()->getColor()
                )
                ->setPaddingLeft($paddingLeft)
                ->setPaddingRight($paddingRight)
                ->setPaddingTop($paddingTop)
                ->setPaddingBottom($paddingBottom)
                ->setBackgroundColor(
                    $header
                        ? $this->getStyle()->getHeaderBackgroundColor()
                        : $this->getStyle()->getBackgroundColor()
                );

            $rectangle = new Rectangle(
                $width,
                null,
                null,
                null,
                $cell->getStyle()->getAlign()
            );
            $panel = new PanelComponent($this->getOutput(), $value, $panelStyle);

            $grid->appendBottom($panel->getSymbols($rectangle)->getArrayCopy());
        }

        if ($height && $grid->getHeight() < $height) {
            $grid->wrapBottom(
                $height - $grid->getHeight(),
                $width,
                ' '
            );
        }

        $grid->prependStyles([
            new Style(
                null,
                $header ? $this->getStyle()->getHeaderColor() : $this->getStyle()->getColor(),
                $header ? $this->getStyle()->getHeaderBackgroundColor() : $this->getStyle()->getBackgroundColor(),
            ),
        ]);

        return $grid->getSymbols();
    }

    /**
     * Возвращает колонки для отрисовки
     *
     * @param TableCellInterface[] $row
     *
     * @return int[]
     */
    private function getRowColumns(array $row, int $columnsCount)
    {
        $columns = range(0, $columnsCount - 1);
        foreach ($row as $column => $cell) {
            assert(is_int($column));
            if ($cell->getColspan() > 1) {
                $columns = array_diff($columns, range($column + 1, $column + $cell->getColspan() - 1));
            }
        }

        return $columns;
    }

    /**
     * Подсчитывает кол-во колонок в таблице
     */
    private function getColumnsCount(): int
    {
        $count = [0];
        foreach (array_merge($this->headers, $this->rows) as $row) {
            $count[] = $this->getRowColumnsCount($row);
        }

        return max($count);
    }

    /**
     * Подсчитывает кол-во колонок в конкретной строке
     *
     * @param TableCellInterface[] $row
     */
    private function getRowColumnsCount(array $row): int
    {
        $count = count($row);
        foreach ($row as $column) {
            $count += $column->getColspan() - 1;
        }

        return $count;
    }

    /**
     * Формирует строки
     *
     * @param TableCellInterface[][] $rows
     *
     * @return TableCellInterface[][]
     */
    private function buildRows(array $rows): array
    {
        $tableRows = [];
        foreach ($rows as $row) {
            $tableRows[] = $this->fillCells($row);
        }

        return $tableRows;
    }

    /**
     * Формирует строку колонками
     *
     * @param TableCellInterface[] $row
     *
     * @return TableCellInterface[]
     */
    private function fillCells(array $row): array
    {
        $newRow = [];
        foreach ($row as $column => $cell) {
            assert($cell instanceof TableCellInterface);
            assert(is_int($column));
            $newRow[] = $cell;
            if ($cell->getColspan() > 1) {
                foreach (range($column + 1, $column + $cell->getColspan() - 1) as $index) {
                    $newRow[$index] = (new TableCellColspan())->setValue(' ');
                }
            }
        }

        return $newRow;
    }

    /**
     * Расчитывает ширину колонок
     *
     * @param TableCellInterface[][] $rows
     *
     * @return int[]
     */
    private function calculateColumnsWidth(array $rows, int $columnsCount): array
    {
        $tableWidth = $this->getStyle()->getWidth();
        $cellWidthBased = null;
        if ($tableWidth) {
            $cellWidthBased = (int) ceil(($tableWidth - $columnsCount) / $columnsCount);
            if (!$cellWidthBased) {
                $cellWidthBased = 1;
            }
        }
        $width = [];
        for ($column = 0; $column < $columnsCount; $column++) {
            $lengths = [0];
            $cellWidth = 0;
            $minWidth = 0;
            foreach ($rows as $row) {
                if (array_key_exists($column, $row)) {
                    $cell = $row[$column];
                    if ($cell->getStyle()->getWidth()) {
                        if ($cellWidth < $cell->getStyle()->getWidth()) {
                            $cellWidth = $cell->getStyle()->getWidth();
                        }
                    }

                    $paddingLeft = $this->getStyle()->getPaddingLeft();
                    if ($cell->getStyle()->getPaddingLeft()) {
                        $paddingLeft = $cell->getStyle()->getPaddingLeft();
                    }
                    $paddingRight = $this->getStyle()->getPaddingRight();
                    if ($cell->getStyle()->getPaddingRight()) {
                        $paddingRight = $cell->getStyle()->getPaddingRight();
                    }
                    $calcWidth = 1 + (int) $paddingLeft + (int) $paddingRight;
                    if (!$minWidth || $minWidth < $calcWidth) {
                        $minWidth = $calcWidth;
                    }
                }
                $length = $this->getCellWidth($row, $column);

                if ($length) {
                    $lengths[] = $length;
                }
            }
            $maxWidth = max($lengths);

            if ($tableWidth && !$cellWidth) {
                if ($column === $columnsCount - 1 && $tableWidth - array_sum($width) > 0) {
                    $width[$column] = (int) ($tableWidth - array_sum($width));
                } else {
                    $width[$column] = (int) max($minWidth, $cellWidthBased);
                }
            } else {
                $width[$column] = $cellWidth ? max($minWidth, $cellWidth) : $maxWidth;
            }
        }

        return $width;
    }

    /**
     * Расчитывает ширину колонки
     *
     * @param TableCellInterface[] $row
     */
    private function getCellWidth(array $row, int $column): int
    {
        $width = 0;
        if (array_key_exists($column, $row)) {
            $cell = $row[$column];

            $grid = new Grid();
            foreach ($cell->getValue() as $value) {
                if ($value instanceof ComponentInterface) {
                    $componentWidth = null;
                    /** @psalm-suppress MixedArgument */
                    if (
                        method_exists($value, 'getStyle')
                        && $value->getStyle()
                        && method_exists($value->getStyle(), 'getWidth')
                        && $value->getStyle()->getWidth()
                    ) {
                        $componentWidth = (int) $value->getStyle()->getWidth();
                    }
                    $textRectangle = new Rectangle(
                        $componentWidth,
                        null,
                        null,
                        null,
                        $cell->getStyle()->getAlign()
                    );
                    $grid->appendBottom($value->getSymbols($textRectangle)->getArrayCopy());

                    continue;
                }
                $panelStyle = new PanelStyle();
                $rectangle = new Rectangle();
                $panel = new PanelComponent($this->getOutput(), $value, $panelStyle);

                $grid->appendBottom($panel->getSymbols($rectangle)->getArrayCopy());
            }

            $width = $grid->getMaxWidth();
            $paddingLeft = $this->getStyle()->getPaddingLeft();
            if ($cell->getStyle()->getPaddingLeft()) {
                $paddingLeft = $cell->getStyle()->getPaddingLeft();
            }
            $paddingRight = $this->getStyle()->getPaddingRight();
            if ($cell->getStyle()->getPaddingRight()) {
                $paddingRight = $cell->getStyle()->getPaddingRight();
            }
            $width = $width + (int) $paddingLeft + (int) $paddingRight + 1;
            if ($cell->getColspan() > 1) {
                $width = $width / $cell->getColspan();
            }
        }

        return (int) $width;
    }

    /**
     * Возвращает оформление границ
     */
    private function getBorder(): BorderInterface
    {
        return BorderRegistry::get($this->getStyle()->getBorder());
    }
}
