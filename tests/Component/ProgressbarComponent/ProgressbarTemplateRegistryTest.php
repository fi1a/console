<?php

declare(strict_types=1);

namespace Fi1a\Unit\Console\Component\ProgressbarComponent;

use Fi1a\Console\Component\ProgressbarComponent\ProgressbarTemplateRegistry;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * Реестр шаблонов
 */
class ProgressbarTemplateRegistryTest extends TestCase
{
    /**
     * Добавить
     */
    public function testAdd(): void
    {
        $this->assertTrue(ProgressbarTemplateRegistry::add('test1', '[{{bar}}]'));
        $this->assertFalse(ProgressbarTemplateRegistry::add('test1', '[{{bar}}]'));
    }

    /**
     * Наличие
     *
     * @depends testAdd
     */
    public function testHas(): void
    {
        $this->assertTrue(ProgressbarTemplateRegistry::has('test1'));
        $this->assertFalse(ProgressbarTemplateRegistry::has('unknown'));
    }

    /**
     * Наличие
     *
     * @depends testAdd
     */
    public function testGet(): void
    {
        $this->assertEquals('[{{bar}}]', ProgressbarTemplateRegistry::get('test1'));
    }

    /**
     * Наличие
     *
     * @depends testAdd
     */
    public function testGetException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        ProgressbarTemplateRegistry::get('unknown');
    }

    /**
     * Наличие
     *
     * @depends testAdd
     */
    public function testDelete(): void
    {
        $this->assertTrue(ProgressbarTemplateRegistry::delete('test1'));
        $this->assertFalse(ProgressbarTemplateRegistry::delete('test1'));
    }
}
