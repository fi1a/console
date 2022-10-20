<?php

declare(strict_types=1);

namespace Fi1a\Console\IO\Formatter\AST;

use Fi1a\Collection\ICollection;

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
 */
interface SymbolsInterface extends ICollection
{
}
