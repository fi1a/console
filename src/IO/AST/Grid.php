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
        if ($symbols->isEmpty()) {
            return true;
        }
        $current = 0;
        $lastPosition = 0;
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
                if (!$lastPosition) {
                    $lastPosition = $current - 1;
                }
                $startSlice = $lastPosition;
                /**
                 * @var SymbolInterface $startSliceSymbol
                 */
                $startSliceSymbol = $symbols[$startSlice];
                while (
                    preg_match('/[\s\t]+/mui', $startSliceSymbol->getValue()) > 0
                    && $startSlice < count($symbols)
                ) {
                    $startSlice++;
                    /**
                     * @var Symbol $startSliceSymbol
                     */
                    $startSliceSymbol = $symbols[$startSlice];
                }
                $current = $startSlice;
                $symbols->exchangeArray(
                    array_merge(
                        array_slice($symbols->getArrayCopy(), 0, $lastPosition),
                        [new Symbol(PHP_EOL, $symbol->getStyles()->getArrayCopy())],
                        array_slice($symbols->getArrayCopy(), $startSlice),
                    )
                );
            }
            if (preg_match('/[\s\t]+/mui', $symbol->getValue()) > 0) {
                $lastPosition = $current;
            }
            if ($symbol->getValue() === PHP_EOL || $lineWidth >= $width) {
                $lineWidth = 0;
                $lastPosition = 0;
            }

            $current++;
            $lineWidth++;
        } while ($current < count($symbols));
        if ($lineWidth >= $width) {
            if (!$lastPosition) {
                $lastPosition = $current - 1;
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
        $lineWidth = 1;
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
                    $lineWidth = 0;
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
    public function set(int $line, int $column, string $value): bool
    {
        $currentLine = 1;
        $currentColumn = 1;
        $symbols = $this->getSymbols();
        foreach ($symbols as $index => $symbol) {
            assert($symbol instanceof SymbolInterface);
            assert(is_int($index));
            if ($currentLine === $line && $currentColumn === $column) {
                $clone = clone $symbol;
                $clone->setValue($value);
                $symbols->set($index, $clone);

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
        $height = 1;
        foreach ($this->getSymbols() as $symbol) {
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
}
