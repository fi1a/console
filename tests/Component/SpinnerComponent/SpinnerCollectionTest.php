<?php

declare(strict_types=1);

namespace Fi1a\Unit\Console\Component\SpinnerComponent;

use Fi1a\Console\Component\SpinnerComponent\DotsSpinner;
use Fi1a\Console\Component\SpinnerComponent\SpinnerCollection;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * Коллекция спинеров
 */
class SpinnerCollectionTest extends TestCase
{
    /**
     * Добавить
     */
    public function testAdd(): void
    {
        $this->assertTrue(SpinnerCollection::add('test1', new DotsSpinner()));
        $this->assertFalse(SpinnerCollection::add('test1', new DotsSpinner()));
    }

    /**
     * Наличие
     *
     * @depends testAdd
     */
    public function testHas(): void
    {
        $this->assertFalse(SpinnerCollection::has('unknown'));
        $this->assertTrue(SpinnerCollection::has('test1'));
    }

    /**
     * Получение
     *
     * @depends testAdd
     */
    public function testGet(): void
    {
        $this->assertInstanceOf(DotsSpinner::class, SpinnerCollection::get('test1'));
    }

    /**
     * Получение
     *
     * @depends testAdd
     */
    public function testGetException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        SpinnerCollection::get('unknown');
    }

    /**
     * Удаление
     *
     * @depends testAdd
     */
    public function testDelete(): void
    {
        $this->assertTrue(SpinnerCollection::delete('test1'));
        $this->assertFalse(SpinnerCollection::delete('test1'));
    }
}
