<?php

declare(strict_types=1);

namespace Fi1a\Unit\Console\IO;

use Fi1a\Console\Definition\Validation;
use Fi1a\Console\IO\Option;
use PHPUnit\Framework\TestCase;

/**
 * Опция
 */
class OptionTest extends TestCase
{
    /**
     * Значение
     */
    public function testValue(): void
    {
        $option = new Option();
        $this->assertNull($option->getValue());
        $option->default('default');
        $this->assertEquals('default', $option->getValue());
        $option->setValue('value');
        $this->assertEquals('value', $option->getValue());
    }

    /**
     * Множественное значение
     */
    public function testMultiple(): void
    {
        $option = new Option();
        $this->assertFalse($option->isMultiple());
        $option->multiple();
        $this->assertTrue($option->isMultiple());
        $option->multiple(false);
        $this->assertFalse($option->isMultiple());
    }

    /**
     * Валидация аргументов и опций
     */
    public function testValidation(): void
    {
        $option = new Option();
        $this->assertNull($option->getValidation());
        $this->assertInstanceOf(Validation::class, $option->validation());
        $this->assertInstanceOf(Validation::class, $option->getValidation());
    }
}
