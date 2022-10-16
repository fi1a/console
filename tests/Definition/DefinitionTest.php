<?php

declare(strict_types=1);

namespace Fi1a\Unit\Console\Definition;

use Fi1a\Console\Definition\Definition;
use Fi1a\Console\Definition\Exception\UnknownOptionException;
use Fi1a\Console\Definition\Option;
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
     * Значения
     */
    public function testValues(): void
    {
        $definition = new Definition();
        $definition->addOption('option1', 'opt1');
        $definition->addOption('option2', 'opt2');
        $definition->addOption('option3', 'opt3');
        $definition->parseValues(new ArrayInputArguments(['--option1=1', 'argument1', '--option2', '-opt3', 'value']));
        $this->assertEquals('1', $definition->getOption('option1')->getValue());
        $this->assertTrue($definition->getOption('option2')->getValue());
        $this->assertEquals('value', $definition->getShortOption('opt3')->getValue());
    }

    /**
     * Значения
     */
    public function testValuesUnknownOption(): void
    {
        $this->expectException(UnknownOptionException::class);
        $definition = new Definition();
        try {
            $definition->parseValues(new ArrayInputArguments(['--option1=1']));
        } catch (UnknownOptionException $exception) {
            $this->assertEquals('option1', $exception->getName());

            throw $exception;
        }
    }

    /**
     * Значения
     */
    public function testValuesUnknownShortOption(): void
    {
        $this->expectException(UnknownOptionException::class);
        $definition = new Definition();
        try {
            $definition->parseValues(new ArrayInputArguments(['-opt1', 'value']));
        } catch (UnknownOptionException $exception) {
            $this->assertEquals('opt1', $exception->getName());

            throw $exception;
        }
    }
}
