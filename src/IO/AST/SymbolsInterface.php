<?php

declare(strict_types=1);

namespace Fi1a\Console\IO\AST;

use Fi1a\Collection\DataType\IMapArrayObject;

/**
 * Символы
 *
 * @method SymbolInterface first()
 * @method SymbolInterface last()
 * @method SymbolInterface delete($key)
 * @method SymbolInterface put($key, $value)
 * @method SymbolInterface putIfAbsent($key, $value)
 * @method SymbolInterface replace($key, $value)
 * @method SymbolInterface[] column(string $name)
 * @method SymbolInterface[] getArrayCopy()
 */
interface SymbolsInterface extends IMapArrayObject
{
}
