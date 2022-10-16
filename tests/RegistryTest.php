<?php

declare(strict_types=1);

namespace Fi1a\Unit\Console;

use Fi1a\Console\Registry;
use PHPUnit\Framework\TestCase;

/**
 * Реестр
 *
 * @runTestsInSeparateProcesses
 */
class RegistryTest extends TestCase
{
    /**
     * Аргументы консоли
     */
    public function testArgv(): void
    {
        $argv = ['--option1'];
        $this->assertTrue(Registry::setArgv($argv));
        $this->assertEquals($argv, Registry::getArgv());
    }
}
