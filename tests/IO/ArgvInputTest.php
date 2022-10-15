<?php

declare(strict_types=1);

namespace Fi1a\Unit\Console\IO;

use Fi1a\Console\IO\ArgvInput;
use PHPUnit\Framework\TestCase;

/**
 * Ввод из массива аргументов CLI
 */
class ArgvInputTest extends TestCase
{
    /**
     * Ввод из массива аргументов CLI
     */
    public function testGetTokens(): void
    {
        $array = ['test', 'command', '--force'];
        $input = new ArgvInput($array);
        $this->assertEquals(['command', '--force'], $input->getTokens());
    }
}
