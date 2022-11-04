<?php

declare(strict_types=1);

namespace Fi1a\Unit\Console\Component\TreeComponent;

use Fi1a\Console\Component\TreeComponent\LineRegistry;
use Fi1a\Console\Component\TreeComponent\NormalLine;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * Реестр
 */
class LineRegistryTest extends TestCase
{
    /**
     * Добавить
     */
    public function testAdd(): void
    {
        $this->assertTrue(LineRegistry::add('test1', new NormalLine()));
        $this->assertFalse(LineRegistry::add('test1', new NormalLine()));
    }

    /**
     * Наличие
     *
     * @depends testAdd
     */
    public function testHas(): void
    {
        $this->assertFalse(LineRegistry::has('unknown'));
        $this->assertTrue(LineRegistry::has('test1'));
    }

    /**
     * Получение
     *
     * @depends testAdd
     */
    public function testGet(): void
    {
        $this->assertInstanceOf(NormalLine::class, LineRegistry::get('test1'));
    }

    /**
     * Получение
     *
     * @depends testAdd
     */
    public function testGetException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        LineRegistry::get('unknown');
    }

    /**
     * Удаление
     *
     * @depends testAdd
     */
    public function testDelete(): void
    {
        $this->assertTrue(LineRegistry::delete('test1'));
        $this->assertFalse(LineRegistry::delete('test1'));
    }
}
