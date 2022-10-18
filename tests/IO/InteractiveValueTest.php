<?php

declare(strict_types=1);

namespace Fi1a\Unit\Console\IO;

use Fi1a\Console\Definition\Validation;
use Fi1a\Console\IO\InteractiveValue;
use PHPUnit\Framework\TestCase;

/**
 * Значение для интерактивного ввода
 */
class InteractiveValueTest extends TestCase
{
    /**
     * Значение
     */
    public function testValue(): void
    {
        $value = new InteractiveValue();
        $this->assertNull($value->getValue());
        $value->default('default');
        $this->assertEquals('default', $value->getValue());
        $value->setValue('value');
        $this->assertEquals('value', $value->getValue());
    }

    /**
     * Множественное значение
     */
    public function testMultiple(): void
    {
        $value = new InteractiveValue();
        $this->assertFalse($value->isMultiple());
        $value->multiple();
        $this->assertTrue($value->isMultiple());
        $value->multiple(false);
        $this->assertFalse($value->isMultiple());
    }

    /**
     * Валидация аргументов и опций
     */
    public function testValidation(): void
    {
        $value = new InteractiveValue();
        $this->assertNull($value->getValidation());
        $this->assertInstanceOf(Validation::class, $value->validation());
        $this->assertInstanceOf(Validation::class, $value->getValidation());
    }

    /**
     * Описание
     */
    public function testDescription(): void
    {
        $value = new InteractiveValue();
        $value->description('test');
        $this->assertEquals('test', $value->getDescription());
    }
}
