<?php

declare(strict_types=1);

namespace Fi1a\Unit\Console\IO;

use Fi1a\Console\IO\ConsoleOutput;
use Fi1a\Console\IO\ConsoleOutputInterface;
use Fi1a\Console\IO\Formatter;
use Fi1a\Console\IO\InputInterface;
use Fi1a\Console\IO\InteractiveInput;
use Fi1a\Console\IO\InteractiveValue;
use Fi1a\Console\IO\Stream;
use Fi1a\Console\IO\StreamInput;
use Fi1a\Console\IO\StreamInterface;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * Тестирование интерактивного ввода
 */
class InteractiveInputTest extends TestCase
{
    /**
     * @var InteractiveInput
     */
    private static $interactive;

    /**
     * @var StreamInterface
     */
    private static $resource;

    /**
     * Конструктор
     */
    public function testConstructor()
    {
        static::$resource = new Stream('php://temp', 'w');
        $output = new ConsoleOutput(new Formatter());
        $output->setStream(new Stream('php://memory', 'w'));
        $errorOutput = $output->getErrorOutput();
        /**
         * @var ConsoleOutput $errorOutput
         */
        $errorOutput->setStream(new Stream('php://memory', 'w'));
        static::$interactive = new InteractiveInput(
            $output,
            new StreamInput(static::$resource)
        );
        $this->assertInstanceOf(ConsoleOutput::class, $output);
        $this->assertInstanceOf(ConsoleOutputInterface::class, static::$interactive->getOutput());
        $this->assertInstanceOf(InputInterface::class, static::$interactive->getInput());
    }

    /**
     * Добавление
     *
     * @depends testConstructor
     */
    public function testAdd()
    {
        $this->assertInstanceOf(InteractiveValue::class, static::$interactive->addValue('value1'));
        $this->assertInstanceOf(InteractiveValue::class, static::$interactive->addValue('value2'));
    }

    /**
     * Добавление (исключение при пустом имени)
     *
     * @depends testConstructor
     */
    public function testAddEmptyNameException()
    {
        $this->expectException(InvalidArgumentException::class);
        static::$interactive->addValue('');
    }

    /**
     * Добавление (исключение при наличии значения)
     *
     * @depends testConstructor
     */
    public function testAddExistException()
    {
        $this->expectException(InvalidArgumentException::class);
        static::$interactive->addValue('value1');
    }

    /**
     * Получить значение
     *
     * @depends testAdd
     */
    public function testGetValue()
    {
        $this->assertFalse(static::$interactive->getValue('unknown'));
        $this->assertInstanceOf(InteractiveValue::class, static::$interactive->getValue('value1'));
    }

    /**
     * Удаление
     *
     * @depends testGetValue
     */
    public function testDeleteValue()
    {
        $this->assertTrue(static::$interactive->deleteValue('value2'));
        $this->assertFalse(static::$interactive->deleteValue('value2'));
    }

    /**
     * Все значения
     *
     * @depends testGetValue
     */
    public function testAllValues()
    {
        $this->assertCount(1, static::$interactive->allValues());
    }

    /**
     * Чтение значений
     *
     * @depends testAllValues
     */
    public function testRead()
    {
        $this->assertTrue(static::$interactive->read());
    }
}
