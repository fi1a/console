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

use const PHP_EOL;

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
    public function testConstructor(): void
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
    public function testAdd(): void
    {
        $value = static::$interactive->addValue('value1');
        $this->assertInstanceOf(InteractiveValue::class, $value);
        $value->description('Тест1');
        $value->validation()->allOf()->required()->integer();
        $this->assertInstanceOf(InteractiveValue::class, static::$interactive->addValue('value2'));
        $value = static::$interactive->addValue('value3');
        $this->assertInstanceOf(InteractiveValue::class, $value);
        $value->description('Тест3');
        $value->multipleValidation()->allOf()->required()->array();
    }

    /**
     * Добавление (исключение при пустом имени)
     *
     * @depends testConstructor
     */
    public function testAddEmptyNameException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        static::$interactive->addValue('');
    }

    /**
     * Добавление (исключение при наличии значения)
     *
     * @depends testConstructor
     */
    public function testAddExistException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        static::$interactive->addValue('value1');
    }

    /**
     * Получить значение
     *
     * @depends testAdd
     */
    public function testGetValue(): void
    {
        $this->assertFalse(static::$interactive->getValue('unknown'));
        $this->assertInstanceOf(InteractiveValue::class, static::$interactive->getValue('value1'));
    }

    /**
     * Удаление
     *
     * @depends testGetValue
     */
    public function testDeleteValue(): void
    {
        $this->assertTrue(static::$interactive->deleteValue('value2'));
        $this->assertFalse(static::$interactive->deleteValue('value2'));
    }

    /**
     * Все значения
     *
     * @depends testGetValue
     */
    public function testAllValues(): void
    {
        $this->assertCount(2, static::$interactive->allValues());
    }

    /**
     * Чтение значений
     *
     * @depends testAllValues
     */
    public function testRead(): void
    {
        static::$resource->write(chr(27) . PHP_EOL);
        static::$resource->write('abc' . PHP_EOL);
        static::$resource->write('1' . PHP_EOL);
        static::$resource->write('2' . PHP_EOL);
        static::$resource->write('3' . PHP_EOL);
        static::$resource->write(chr(27) . PHP_EOL);
        static::$resource->seek(0);
        $this->assertTrue(static::$interactive->read());
    }

    /**
     * Чтение значений
     *
     * @depends testAllValues
     */
    public function testReadMultipleValidatorError(): void
    {
        static::$resource->flush();
        static::$resource->seek(0);
        static::$resource->write(chr(27) . PHP_EOL);
        static::$resource->write('1' . PHP_EOL);
        static::$resource->write(chr(27) . PHP_EOL);
        static::$resource->write('2' . PHP_EOL);
        static::$resource->write('3' . PHP_EOL);
        static::$resource->write(chr(27) . PHP_EOL);
        static::$resource->seek(0);
        $this->assertTrue(static::$interactive->refresh());
        $this->assertTrue(static::$interactive->read());
        $this->assertTrue(static::$interactive->read());
    }

    /**
     * Значения в виде массива
     *
     * @depends testReadMultipleValidatorError
     */
    public function testAsArray(): void
    {
        $this->assertEquals([
            'value1' => '1',
            'value3' => ['2', '3'],
        ], static::$interactive->asArray());
    }
}
