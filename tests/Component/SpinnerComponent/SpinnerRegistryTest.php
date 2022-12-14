<?php

declare(strict_types=1);

namespace Fi1a\Unit\Console\Component\SpinnerComponent;

use Fi1a\Console\Component\SpinnerComponent\DotsSpinner;
use Fi1a\Console\Component\SpinnerComponent\SpinnerRegistry;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * Коллекция спинеров
 */
class SpinnerRegistryTest extends TestCase
{
    /**
     * Добавить
     */
    public function testAdd(): void
    {
        $this->assertTrue(SpinnerRegistry::add('test1', new DotsSpinner()));
        $this->assertFalse(SpinnerRegistry::add('test1', new DotsSpinner()));
    }

    /**
     * Наличие
     *
     * @depends testAdd
     */
    public function testHas(): void
    {
        $this->assertFalse(SpinnerRegistry::has('unknown'));
        $this->assertTrue(SpinnerRegistry::has('test1'));
    }

    /**
     * Получение
     *
     * @depends testAdd
     */
    public function testGet(): void
    {
        $this->assertInstanceOf(DotsSpinner::class, SpinnerRegistry::get('test1'));
    }

    /**
     * Получение
     *
     * @depends testAdd
     */
    public function testGetException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        SpinnerRegistry::get('unknown');
    }

    /**
     * Удаление
     *
     * @depends testAdd
     */
    public function testDelete(): void
    {
        $this->assertTrue(SpinnerRegistry::delete('test1'));
        $this->assertFalse(SpinnerRegistry::delete('test1'));
    }
}
