<?php

declare(strict_types=1);

namespace Fi1a\Unit\Console\IO;

use Fi1a\Console\IO\ArrayInput;
use PHPUnit\Framework\TestCase;

/**
 * Ввод из массива
 */
class ArrayInputTest extends TestCase
{
    /**
     * Ввод из массива
     */
    public function testGetTokens(): void
    {
        $argv = ['command', '--force'];
        $input = new ArrayInput($argv);
        $this->assertEquals($argv, $input->getTokens());
    }
}
