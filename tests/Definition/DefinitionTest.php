<?php

declare(strict_types=1);

namespace Fi1a\Unit\Console\Definition;

use Fi1a\Console\Definition\Argument;
use Fi1a\Console\Definition\Definition;
use Fi1a\Console\Definition\Exception\ValueSetterException;
use Fi1a\Console\Definition\Option;
use Fi1a\Console\Definition\ValueSetter;
use Fi1a\Console\IO\ArrayInputArguments;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * Определение опций и аргументов
 */
class DefinitionTest extends TestCase
{
    /**
     *  Опции
     */
    public function testOption(): void
    {
        $definition = new Definition();
        $this->assertFalse($definition->hasOption('option1'));
        $this->assertFalse($definition->getOption('option1'));
        $this->assertInstanceOf(Option::class, $definition->addOption('option1', 'opt1'));
        $this->assertTrue($definition->hasOption('option1'));
        $this->assertInstanceOf(Option::class, $definition->getOption('option1'));
        $this->assertCount(1, $definition->allOptions());
        $this->assertTrue($definition->deleteOption('option1'));
        $this->assertFalse($definition->deleteOption('option1'));
    }

    /**
     *  Опции
     */
    public function testOptionExisting(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $definition = new Definition();
        $this->assertInstanceOf(Option::class, $definition->addOption('option1', 'opt1'));
        $definition->addOption('option1', 'opt1');
    }

    /**
     *  Опции
     */
    public function testShortOptionExisting(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $definition = new Definition();
        $this->assertInstanceOf(Option::class, $definition->addOption('option1', 'opt'));
        $definition->addOption('option2', 'opt');
    }

    /**
     *  Опции
     */
    public function testOptionException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $definition = new Definition();
        $definition->addOption('');
    }

    /**
     *  Опции
     */
    public function testShortOption(): void
    {
        $definition = new Definition();
        $this->assertFalse($definition->hasShortOption('opt1'));
        $this->assertFalse($definition->getShortOption('opt1'));
        $this->assertInstanceOf(Option::class, $definition->addOption('option1', 'opt1'));
        $this->assertTrue($definition->hasShortOption('opt1'));
        $this->assertInstanceOf(Option::class, $definition->getShortOption('opt1'));
        $this->assertCount(1, $definition->allShortOptions());
        $this->assertTrue($definition->deleteShortOption('opt1'));
        $this->assertFalse($definition->deleteShortOption('opt1'));
    }

    /**
     *  Аргументы
     */
    public function testArgument(): void
    {
        $definition = new Definition();
        $this->assertFalse($definition->hasArgument('argument1'));
        $this->assertFalse($definition->getArgument('argument1'));
        $this->assertInstanceOf(Argument::class, $definition->addArgument('argument1'));
        $this->assertTrue($definition->hasArgument('argument1'));
        $this->assertInstanceOf(Argument::class, $definition->getArgument('argument1'));
        $this->assertCount(1, $definition->allArguments());
        $this->assertTrue($definition->deleteArgument('argument1'));
        $this->assertFalse($definition->deleteArgument('argument1'));
    }

    /**
     *  Опции
     */
    public function testArgumentException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $definition = new Definition();
        $definition->addArgument('');
    }

    /**
     *  Опции
     */
    public function testArgumentExisting(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $definition = new Definition();
        $this->assertInstanceOf(Argument::class, $definition->addArgument('argument1'));
        $definition->addArgument('argument1');
    }

    /**
     * Значения
     */
    public function testValues(): void
    {
        $definition = new Definition();
        $definition->addOption('option1', 'opt1');
        $definition->addOption('option2', 'opt2');
        $definition->addOption('option3', 'opt3');
        $definition->addArgument('arg1')->multiple();
        $valueSetter = new ValueSetter(
            $definition,
            new ArrayInputArguments(['--option1=1', 'argument1', 'argument2', '--option2', '-opt3', 'value'])
        );
        $this->assertTrue($valueSetter->setValues());
        $this->assertEquals('1', $definition->getOption('option1')->getValue());
        $this->assertTrue($definition->getOption('option2')->getValue());
        $this->assertEquals('value', $definition->getShortOption('opt3')->getValue());
        $this->assertEquals(['argument1', 'argument2'], $definition->getArgument('arg1')->getValue());
    }

    /**
     * Значения
     */
    public function testValuesMultipleOptions(): void
    {
        $definition = new Definition();
        $definition->addOption('option1', 'opt1')->multiple();
        $definition->addOption('option2', 'opt2')->multiple();
        $valueSetter = new ValueSetter(
            $definition,
            new ArrayInputArguments(['--option1=1, 2, 3', '-opt2', '1, 2, 3'])
        );
        $this->assertTrue($valueSetter->setValues());
        $this->assertEquals(['1', '2', '3'], $definition->getOption('option1')->getValue());
        $this->assertEquals(['1', '2', '3'], $definition->getShortOption('opt2')->getValue());
    }

    /**
     * Значения
     */
    public function testValuesArgument(): void
    {
        $definition = new Definition();
        $definition->addArgument('arg1');
        $definition->addArgument('arg2');
        $definition->addArgument('arg3')->multiple();
        $valueSetter = new ValueSetter(
            $definition,
            new ArrayInputArguments(['argument1', 'argument2',])
        );
        $this->assertTrue($valueSetter->setValues());
        $this->assertEquals('argument1', $definition->getArgument('arg1')->getValue());
        $this->assertEquals('argument2', $definition->getArgument('arg2')->getValue());
        $this->assertNull($definition->getArgument('arg3')->getValue());
    }

    /**
     * Значения
     */
    public function testValuesUnknownArguments(): void
    {
        $this->expectException(ValueSetterException::class);
        $definition = new Definition();
        $definition->addArgument('arg1');
        $valueSetter = new ValueSetter(
            $definition,
            new ArrayInputArguments(['argument1', 'argument2',])
        );
        $valueSetter->setValues();
    }

    /**
     * Значения
     */
    public function testValuesUnknownOption(): void
    {
        $this->expectException(ValueSetterException::class);
        $definition = new Definition();
        $valueSetter = new ValueSetter(
            $definition,
            new ArrayInputArguments(['--option1=1'])
        );
        $valueSetter->setValues();
    }

    /**
     * Значения
     */
    public function testValuesUnknownShortOption(): void
    {
        $this->expectException(ValueSetterException::class);
        $definition = new Definition();
        $valueSetter = new ValueSetter(
            $definition,
            new ArrayInputArguments(['-opt1', 'value'])
        );
        $valueSetter->setValues();
    }

    /**
     * Валидация
     */
    public function testValidate(): void
    {
        $definition = new Definition();
        $definition->addOption('option1', 'opt1')->validation()->allOf()->required()->integer();
        $definition->addArgument('arg1')->validation()->allOf()->required()->array();
        $valueSetter = new ValueSetter(
            $definition,
            new ArrayInputArguments([])
        );
        $valueSetter->setValues();
        $result = $definition->validate();
        $this->assertFalse($result->isSuccess());
    }
}
