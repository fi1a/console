<?php

declare(strict_types=1);

namespace Fi1a\Unit\Console\IO;

use Fi1a\Console\IO\ArrayInputArguments;
use PHPUnit\Framework\TestCase;

/**
 * Ввод из массива
 */
class ArrayInputArgumentsTest extends TestCase
{
    /**
     * Ввод из массива
     */
    public function testGetTokens(): void
    {
        $array = ['command', '--force'];
        $input = new ArrayInputArguments($array);
        $this->assertEquals($array, $input->getTokens());
    }
}
