<?php

declare(strict_types=1);

namespace Fi1a\Console\IO\AST;

use InvalidArgumentException;

use const PHP_EOL;

/**
 * Работа с символами используя линии и колонки
 */
class Grid implements GridInterface
{
    /**
     * @var SymbolsInterface
     * @psalm-suppress PropertyNotSetInConstructor
     */
    private $symbols;

    /**
     * @inheritDoc
     */
    public function __construct(?SymbolsInterface $symbols = null)
    {
        if (!$symbols) {
            $symbols = new Symbols();
        }
        $this->setSymbols($symbols);
    }

    /**
     * @inheritDoc
     */
    public function setSymbols(SymbolsInterface $symbols): bool
    {
        $this->symbols = $symbols;

        return true;
    }

    /**
     * @inheritDoc
     */
    public function getSymbols(): SymbolsInterface
    {
        return $this->symbols;
    }

    /**
     * @inheritDoc
     */
    public function wordWrap(int $width, ?int $left = null): bool
    {
        $symbols = $this->getSymbols();
        if ($symbols->isEmpty() || !$width) {
            return true;
        }
        $current = 0;
        $lastPosition = -1;
        $lineWidth = 0;
        if ($left) {
            $width += $left;
        }

        do {
            /**
             * @var SymbolInterface $symbol
             */
            $symbol = $symbols[$current];
            if ($lineWidth >= $width) {
                if ($lastPosition < 0) {
                    $lastPosition = $current;
                }
                $startSlice = $lastPosition;
                $current = $startSlice;
                /**
                 * @var SymbolInterface|null $startSliceSymbol
                 */
                $startSliceSymbol = $symbols[$startSlice] ?? null;
                if ($startSliceSymbol && preg_match('/[\s]+/mui', $startSliceSymbol->getValue()) > 0) {
                    $startSlice++;
                }
                $symbols->exchangeArray(
                    array_merge(
                        array_slice($symbols->getArrayCopy(), 0, $lastPosition),
                        [new Symbol(PHP_EOL, $symbol->getStyles()->getArrayCopy())],
                        array_slice($symbols->getArrayCopy(), $startSlice),
                    )
                );
                $current++;
            }
            if (preg_match('/[\s]+/mui', $symbol->getValue()) > 0) {
                $lastPosition = $current;
            }
            if ($symbol->getValue() === PHP_EOL || $lineWidth >= $width) {
                $lineWidth = 0;
                $lastPosition = -1;
            }

            $current++;
            $lineWidth++;
        } while ($current < count($symbols));
        if ($lineWidth >= $width) {
            if ($lastPosition < 0) {
                $lastPosition = $current;
            }
            $startSlice = $lastPosition;
            $symbols->exchangeArray(
                array_merge(
                    array_slice($symbols->getArrayCopy(), 0, $lastPosition),
                    [new Symbol(PHP_EOL, $symbol->getStyles()->getArrayCopy())],
                    array_slice($symbols->getArrayCopy(), $startSlice),
                )
            );
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function pad(int $width, string $paddingChar = ' ', string $align = self::ALIGN_LEFT): bool
    {
        $align = mb_strtolower($align);
        if (
            !in_array(
                $align,
                [self::ALIGN_CENTER, self::ALIGN_LEFT, self::ALIGN_RIGHT]
            )
        ) {
            throw new InvalidArgumentException(
                sprintf('Ошибка в переданном значении "%s" выравнивания', $align)
            );
        }
        $symbols = $this->getSymbols();
        $current = 0;
        $lineWidth = 0;
        $startLine = 0;
        $symbol = null;
        if (!$symbols->isEmpty()) {
            do {
                /**
                 * @var SymbolInterface $symbol
                 */
                $symbol = $symbols[$current];

                if ($symbol->getValue() === PHP_EOL) {
                    if ($lineWidth < $width) {
                        if ($align === self::ALIGN_LEFT) {
                            $padSymbol = new Symbol($paddingChar, $symbol->getStyles()->getArrayCopy());
                            $current = $this->padRight(
                                $width - $lineWidth,
                                $padSymbol,
                                $current,
                                $symbols
                            );
                        } elseif ($align === self::ALIGN_RIGHT) {
                            /**
                             * @var SymbolInterface|null $startLineSymbol
                             */
                            $startLineSymbol = $symbols[$startLine] ?? null;
                            $padSymbol = new Symbol(
                                $paddingChar,
                                $startLineSymbol ? $startLineSymbol->getStyles()->getArrayCopy() : []
                            );
                            $current = $this->padLeft(
                                $width - $lineWidth,
                                $padSymbol,
                                $startLine,
                                $current,
                                $symbols
                            );
                        } else {
                            $padSymbol = new Symbol($paddingChar, $symbol->getStyles()->getArrayCopy());
                            $current = $this->padRight(
                                (int) floor(($width - $lineWidth) / 2),
                                $padSymbol,
                                $current,
                                $symbols
                            );
                            /**
                             * @var SymbolInterface|null $startLineSymbol
                             */
                            $startLineSymbol = $symbols[$startLine] ?? null;
                            $padSymbol = new Symbol(
                                $paddingChar,
                                $startLineSymbol ? $startLineSymbol->getStyles()->getArrayCopy() : []
                            );
                            $current = $this->padLeft(
                                (int) ceil(($width - $lineWidth) / 2),
                                $padSymbol,
                                $startLine,
                                $current,
                                $symbols
                            );
                        }
                    }
                    $lineWidth = -1;
                    $startLine = $current + 1;
                }

                $current++;
                $lineWidth++;
            } while ($current < count($symbols));
        }

        if ($lineWidth < $width) {
            if ($align === self::ALIGN_LEFT) {
                $padSymbol = new Symbol($paddingChar, $symbol ? $symbol->getStyles()->getArrayCopy() : []);
                $this->padRight(
                    $width - $lineWidth,
                    $padSymbol,
                    $current,
                    $symbols
                );
            } elseif ($align === self::ALIGN_RIGHT) {
                /**
                 * @var SymbolInterface|null $startLineSymbol
                 */
                $startLineSymbol = $symbols[$startLine] ?? null;
                $padSymbol = new Symbol(
                    $paddingChar,
                    $startLineSymbol ? $startLineSymbol->getStyles()->getArrayCopy() : []
                );
                $this->padLeft(
                    $width - $lineWidth,
                    $padSymbol,
                    $startLine,
                    $current,
                    $symbols
                );
            } else {
                $padSymbol = new Symbol($paddingChar, $symbol ? $symbol->getStyles()->getArrayCopy() : []);
                $current = $this->padRight(
                    (int) floor(($width - $lineWidth) / 2),
                    $padSymbol,
                    $current,
                    $symbols
                );
                /**
                 * @var SymbolInterface|null $startLineSymbol
                 */
                $startLineSymbol = $symbols[$startLine] ?? null;
                $padSymbol = new Symbol(
                    $paddingChar,
                    $startLineSymbol ? $startLineSymbol->getStyles()->getArrayCopy() : []
                );
                $this->padLeft(
                    (int) ceil(($width - $lineWidth) / 2),
                    $padSymbol,
                    $startLine,
                    $current,
                    $symbols
                );
            }
        }

        return true;
    }

    /**
     * Выравнивание по левому краю
     */
    private function padLeft(
        int $count,
        Symbol $padSymbol,
        int $startLine,
        int $current,
        SymbolsInterface $symbols
    ): int {
        $fill = array_fill(0, $count, $padSymbol);

        $symbols->exchangeArray(
            array_merge(
                array_slice($symbols->getArrayCopy(), 0, $startLine),
                $fill,
                array_slice($symbols->getArrayCopy(), $startLine),
            )
        );

        return $current + count($fill);
    }

    /**
     * Выравнивание по левому краю
     */
    private function padRight(int $count, Symbol $padSymbol, int $current, SymbolsInterface $symbols): int
    {
        $fill = array_fill(0, $count, $padSymbol);

        $symbols->exchangeArray(
            array_merge(
                array_slice($symbols->getArrayCopy(), 0, $current),
                $fill,
                array_slice($symbols->getArrayCopy(), $current),
            )
        );

        return $current + count($fill);
    }

    /**
     * @inheritDoc
     */
    public function wrap(int $count, string $wrapChar): bool
    {
        $this->wrapLeft($count, $wrapChar);
        $this->wrapRight($count, $wrapChar);

        return true;
    }

    /**
     * @inheritDoc
     */
    public function wrapLeft(int $count, string $wrapChar, array $styles = []): bool
    {
        $symbols = $this->getSymbols();
        if ($symbols->isEmpty()) {
            return true;
        }
        $current = 0;
        $startLine = 0;
        $padSymbol = new Symbol($wrapChar, $styles);
        do {
            $symbol = $symbols[$current];
            assert($symbol instanceof SymbolInterface);
            if ($symbol->getValue() === PHP_EOL) {
                $current = $this->padLeft(
                    $count,
                    $padSymbol,
                    $startLine,
                    $current,
                    $symbols
                );

                $startLine = $current + 1;
            }

            $current++;
        } while ($current < count($symbols));
        $this->padLeft(
            $count,
            $padSymbol,
            $startLine,
            $current,
            $symbols
        );

        return true;
    }

    /**
     * @inheritDoc
     */
    public function wrapRight(int $count, string $wrapChar, array $styles = []): bool
    {
        $symbols = $this->getSymbols();
        if ($symbols->isEmpty()) {
            return true;
        }
        $current = 0;
        $padSymbol = new Symbol($wrapChar, $styles);

        do {
            $symbol = $symbols[$current];
            assert($symbol instanceof SymbolInterface);
            if ($symbol->getValue() === PHP_EOL) {
                $current = $this->padRight(
                    $count,
                    $padSymbol,
                    $current,
                    $symbols
                );
            }

            $current++;
        } while ($current < count($symbols));
        $this->padRight(
            $count,
            $padSymbol,
            $current,
            $symbols
        );

        return true;
    }

    /**
     * @inheritDoc
     */
    public function wrapTop(int $count, int $width, string $wrapChar, array $styles = []): bool
    {
        $symbols = $this->getSymbols()->getArrayCopy();
        $padSymbol = new Symbol($wrapChar, $styles);
        $fill = array_fill(0, $width, $padSymbol);
        if (!$this->getSymbols()->isEmpty()) {
            $fill[] = new Symbol(PHP_EOL, []);
        }
        for ($index = 0; $index < $count; $index++) {
            $symbols = array_merge(
                $fill,
                array_slice($symbols, 0)
            );
        }
        $this->getSymbols()->exchangeArray($symbols);

        return true;
    }

    /**
     * @inheritDoc
     */
    public function wrapBottom(int $count, int $width, string $wrapChar, array $styles = []): bool
    {
        $symbols = $this->getSymbols()->getArrayCopy();
        $padSymbol = new Symbol($wrapChar, $styles);
        $fill = array_fill(0, $width, $padSymbol);
        array_unshift($fill, new Symbol(PHP_EOL, []));
        for ($index = 0; $index < $count; $index++) {
            $symbols = array_merge($symbols, $fill);
        }
        $this->getSymbols()->exchangeArray($symbols);

        return true;
    }

    /**
     * @inheritDoc
     */
    public function setValue(int $line, int $column, string $value, array $styles = []): bool
    {
        $currentLine = 1;
        $currentColumn = 1;
        $symbols = $this->getSymbols();
        foreach ($symbols as $index => $symbol) {
            assert($symbol instanceof SymbolInterface);
            assert(is_int($index));
            if ($currentLine === $line && $currentColumn === $column) {
                $currentSymbol = 0;
                while ($currentSymbol < mb_strlen($value)) {
                    $currentSymbolValue = mb_substr($value, $currentSymbol, 1);

                    if (isset($symbols[$index + $currentSymbol])) {
                        /**
                         * @var SymbolInterface $item
                         */
                        $item = $symbols[$index + $currentSymbol];
                        $item = clone $item;
                        $item->setValue($currentSymbolValue);
                        $item->setStyles(array_merge($item->getStyles()->getArrayCopy(), $styles));
                    } else {
                        $item = new Symbol($currentSymbolValue, $styles);
                    }

                    $symbols->set($index + $currentSymbol, $item);

                    $currentSymbol++;
                }

                break;
            }

            if ($symbol->getValue() === PHP_EOL) {
                $currentLine++;
                $currentColumn = 0;
            }

            $currentColumn++;
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function getHeight(): int
    {
        return $this->getInternalHeight($this->getSymbols()->getArrayCopy());
    }

    /**
     * Вычисляет высоту
     *
     * @param SymbolInterface[] $symbols
     */
    private function getInternalHeight(array $symbols): int
    {
        $height = 1;
        foreach ($symbols as $symbol) {
            assert($symbol instanceof SymbolInterface);
            if ($symbol->getValue() === PHP_EOL) {
                $height++;
            }
        }

        return $height;
    }

    /**
     * @inheritDoc
     */
    public function prependStyles(array $styles): bool
    {
        foreach ($this->getSymbols() as $symbol) {
            assert($symbol instanceof SymbolInterface);
            $symbol->setStyles(array_merge($styles, $symbol->getStyles()->getArrayCopy()));
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function appendStyles(array $styles): bool
    {
        foreach ($this->getSymbols() as $symbol) {
            assert($symbol instanceof SymbolInterface);
            $symbol->setStyles(array_merge($symbol->getStyles()->getArrayCopy(), $styles));
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function truncateHeight(int $height): bool
    {
        $heightCounter = 1;
        foreach ($this->getSymbols() as $index => $symbol) {
            assert($symbol instanceof SymbolInterface);
            assert(is_int($index));
            if ($symbol->getValue() === PHP_EOL) {
                $heightCounter++;
            }
            if ($heightCounter > $height) {
                $this->getSymbols()->exchangeArray(
                    array_slice($this->getSymbols()->getArrayCopy(), 0, $index)
                );

                break;
            }
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function appendRight(array $rightSymbols): bool
    {
        $resultSymbols = new Symbols();
        $leftSymbols = $this->getSymbols();
        if ($leftSymbols->isEmpty()) {
            $this->getSymbols()->exchangeArray($rightSymbols);

            return true;
        }
        $leftWidth = $this->getWidth();
        $rightWidth = $this->getInternalWidth(1, $rightSymbols);

        $leftSymbolCounter = 0;
        $leftStartLine = 0;
        $rightSymbolCounter = 0;
        $rightStartLine = 0;
        do {
            /**
             * @var SymbolInterface|null $leftSymbol
             */
            $leftSymbol = $leftSymbols[$leftSymbolCounter] ?? null;

            if (($leftSymbol && $leftSymbol->getValue() === PHP_EOL) || $leftSymbolCounter >= count($leftSymbols)) {
                if ($rightSymbolCounter >= count($rightSymbols) - 1) {
                    $fill = array_fill(0, $rightWidth, new Symbol(' ', []));
                    $resultSymbols->exchangeArray(
                        array_merge(
                            $resultSymbols->getArrayCopy(),
                            array_slice(
                                $leftSymbols->getArrayCopy(),
                                $leftStartLine,
                                $leftSymbolCounter - $leftStartLine
                            ),
                            $fill,
                            $leftSymbol ? [new Symbol("\n", [])] : []
                        )
                    );
                } else {
                    do {
                        $rightSymbol = $rightSymbols[$rightSymbolCounter] ?? null;
                        if (
                            ($rightSymbol && $rightSymbol->getValue() === PHP_EOL)
                            || $rightSymbolCounter >= count($rightSymbols)
                        ) {
                            $resultSymbols->exchangeArray(
                                array_merge(
                                    $resultSymbols->getArrayCopy(),
                                    array_slice(
                                        $leftSymbols->getArrayCopy(),
                                        $leftStartLine,
                                        $leftSymbolCounter - $leftStartLine
                                    ),
                                    array_slice(
                                        $rightSymbols,
                                        $rightStartLine,
                                        $rightSymbolCounter - $rightStartLine
                                    ),
                                    $rightSymbol || $leftSymbolCounter < count($leftSymbols)
                                        ? [new Symbol("\n", [])]
                                        : []
                                )
                            );

                            $rightStartLine = $rightSymbolCounter + 1;
                            $rightSymbolCounter++;

                            break;
                        }
                        $rightSymbolCounter++;
                    } while ($rightSymbolCounter <= count($rightSymbols));
                }

                $leftStartLine = $leftSymbolCounter + 1;
            }

            $leftSymbolCounter++;
        } while ($leftSymbolCounter <= count($leftSymbols));

        if ($rightSymbolCounter < count($rightSymbols)) {
            do {
                $rightSymbol = $rightSymbols[$rightSymbolCounter] ?? null;
                if (
                    ($rightSymbol && $rightSymbol->getValue() === PHP_EOL)
                    || $rightSymbolCounter >= count($rightSymbols)
                ) {
                    $fill = array_fill(0, $leftWidth, new Symbol(' ', []));
                    $resultSymbols->exchangeArray(
                        array_merge(
                            $resultSymbols->getArrayCopy(),
                            $fill,
                            array_slice(
                                $rightSymbols,
                                $rightStartLine,
                                $rightSymbolCounter - $rightStartLine
                            ),
                            $rightSymbol ? [new Symbol("\n", [])] : []
                        )
                    );

                    $rightStartLine = $rightSymbolCounter + 1;
                }
                $rightSymbolCounter++;
            } while ($rightSymbolCounter <= count($rightSymbols));
        }

        $this->setSymbols($resultSymbols);

        return true;
    }

    /**
     * @inheritDoc
     */
    public function appendBottom(array $bottomSymbols): bool
    {
        if (!count($bottomSymbols)) {
            return true;
        }

        $this->getSymbols()->exchangeArray(
            array_merge(
                $this->getSymbols()->getArrayCopy(),
                count($this->getSymbols()->getArrayCopy()) ? [new Symbol(PHP_EOL, [])] : [],
                $bottomSymbols
            )
        );

        return true;
    }

    /**
     * @inheritDoc
     */
    public function getWidth(int $line = 1): int
    {
        return $this->getInternalWidth($line, $this->getSymbols()->getArrayCopy());
    }

    /**
     * @inheritDoc
     */
    public function getMaxWidth(): int
    {
        $widths = [0];
        $width = 0;
        foreach ($this->getSymbols()->getArrayCopy() as $symbol) {
            if ($symbol->getValue() !== PHP_EOL) {
                $width++;
            }
            if ($symbol->getValue() === PHP_EOL) {
                $widths[] = $width + 1;
                $width = 0;
            }
        }
        $widths[] = $width;

        return max($widths);
    }

    /**
     * Вычисляет ширину
     *
     * @param SymbolInterface[] $symbols
     */
    private function getInternalWidth(int $line, array $symbols): int
    {
        $height = 1;
        $width = 0;
        foreach ($symbols as $symbol) {
            if ($height === $line && $symbol->getValue() !== PHP_EOL) {
                $width++;
            }
            if ($symbol->getValue() === PHP_EOL) {
                $height++;
                if ($height > $line) {
                    break;
                }
            }
        }

        return $width;
    }

    /**
     * @inheritDoc
     */
    public function getImage(): string
    {
        $image = '';
        foreach ($this->getSymbols() as $symbol) {
            assert($symbol instanceof SymbolInterface);
            $image .= $symbol->getValue();
        }

        return $image;
    }
}
