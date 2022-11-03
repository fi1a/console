<?php

declare(strict_types=1);

namespace Fi1a\Unit\Console\Component\ListComponent;

use Fi1a\Console\Component\ListComponent\DecimalListType;
use Fi1a\Console\Component\ListComponent\ListTypeRegistry;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * Реестр
 */
class ListTypeRegistryTest extends TestCase
{
    /**
     * Добавить
     */
    public function testAdd(): void
    {
        $this->assertTrue(ListTypeRegistry::add('test1', new DecimalListType()));
        $this->assertFalse(ListTypeRegistry::add('test1', new DecimalListType()));
    }

    /**
     * Наличие
     *
     * @depends testAdd
     */
    public function testHas(): void
    {
        $this->assertFalse(ListTypeRegistry::has('unknown'));
        $this->assertTrue(ListTypeRegistry::has('test1'));
    }

    /**
     * Получение
     *
     * @depends testAdd
     */
    public function testGet(): void
    {
        $this->assertInstanceOf(DecimalListType::class, ListTypeRegistry::get('test1'));
    }

    /**
     * Получение
     *
     * @depends testAdd
     */
    public function testGetException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        ListTypeRegistry::get('unknown');
    }

    /**
     * Удаление
     *
     * @depends testAdd
     */
    public function testDelete(): void
    {
        $this->assertTrue(ListTypeRegistry::delete('test1'));
        $this->assertFalse(ListTypeRegistry::delete('test1'));
    }
}
