<?php

declare(strict_types=1);

namespace Fi1a\Unit\Console\Component\TableComponent;

use Fi1a\Console\Component\TableComponent\AsciiBorder;
use Fi1a\Console\Component\TableComponent\BorderRegistry;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * Реестр
 */
class BorderRegistryTest extends TestCase
{
    /**
     * Добавить
     */
    public function testAdd(): void
    {
        $this->assertTrue(BorderRegistry::add('test1', new AsciiBorder()));
        $this->assertFalse(BorderRegistry::add('test1', new AsciiBorder()));
    }

    /**
     * Наличие
     *
     * @depends testAdd
     */
    public function testHas(): void
    {
        $this->assertFalse(BorderRegistry::has('unknown'));
        $this->assertTrue(BorderRegistry::has('test1'));
    }

    /**
     * Получение
     *
     * @depends testAdd
     */
    public function testGet(): void
    {
        $this->assertInstanceOf(AsciiBorder::class, BorderRegistry::get('test1'));
    }

    /**
     * Получение
     *
     * @depends testAdd
     */
    public function testGetException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        BorderRegistry::get('unknown');
    }

    /**
     * Удаление
     *
     * @depends testAdd
     */
    public function testDelete(): void
    {
        $this->assertTrue(BorderRegistry::delete('test1'));
        $this->assertFalse(BorderRegistry::delete('test1'));
    }
}
