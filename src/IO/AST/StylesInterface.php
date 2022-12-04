<?php

declare(strict_types=1);

namespace Fi1a\Console\IO\AST;

use Fi1a\Collection\DataType\MapArrayObjectInterface;

/**
 * Коллекция стилей
 *
 * @method StyleInterface first()
 * @method StyleInterface last()
 * @method StyleInterface delete($key)
 * @method StyleInterface put($key, $value)
 * @method StyleInterface putIfAbsent($key, $value)
 * @method StyleInterface replace($key, $value)
 * @method StyleInterface[] column(string $name)
 * @method StyleInterface[] getArrayCopy()
 */
interface StylesInterface extends MapArrayObjectInterface
{
    /**
     * Возвращает вычисленный стиль
     */
    public function getComputedStyle(): StyleInterface;

    /**
     * Сбросить вычисляемый кеш
     */
    public function resetComputedStyleCache(): bool;
}
