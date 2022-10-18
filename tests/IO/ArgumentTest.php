<?php

declare(strict_types=1);

namespace Fi1a\Unit\Console\IO;

use Fi1a\Console\Definition\Validation;
use Fi1a\Console\IO\Argument;
use PHPUnit\Framework\TestCase;

/**
 * Аргумент
 */
class ArgumentTest extends TestCase
{
    /**
     * Значение
     */
    public function testValue(): void
    {
        $argument = new Argument();
        $this->assertNull($argument->getValue());
        $argument->default('default');
        $this->assertEquals('default', $argument->getValue());
        $argument->setValue('value');
        $this->assertEquals('value', $argument->getValue());
    }

    /**
     * Множественное значение
     */
    public function testMultiple(): void
    {
        $argument = new Argument();
        $this->assertFalse($argument->isMultiple());
        $argument->multiple();
        $this->assertTrue($argument->isMultiple());
        $argument->multiple(false);
        $this->assertFalse($argument->isMultiple());
    }

    /**
     * Валидация аргументов и опций
     */
    public function testValidation(): void
    {
        $argument = new Argument();
        $this->assertNull($argument->getValidation());
        $this->assertInstanceOf(Validation::class, $argument->validation());
        $this->assertInstanceOf(Validation::class, $argument->getValidation());
    }

    /**
     * Описание
     */
    public function testDescription(): void
    {
        $argument = new Argument();
        $argument->description('test');
        $this->assertEquals('test', $argument->getDescription());
    }
}
