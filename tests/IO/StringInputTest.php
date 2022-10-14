<?php

declare(strict_types=1);

namespace Fi1a\Unit\Console\IO;

use Fi1a\Console\IO\StringInput;
use PHPUnit\Framework\TestCase;

/**
 * Тестирование ввода из строки
 */
class StringInputTest extends TestCase
{
    /**
     * Провайдер данных для теста testStringInput
     *
     * @return string[][]
     */
    public function dataProviderStringInput(): array
    {
        return [
            [
                'info --colors -lc "ru ,en" argument',
                ['info', '--colors', '-lc', 'ru ,en', 'argument'],
            ],
            [
                'info --colors --locale="ru ,en" argument',
                ['info', '--colors', '--locale=ru ,en', 'argument'],
            ],
        ];
    }

    /**
     * Тестирование ввода из строки
     *
     * @param string[]  $tokes
     *
     * @dataProvider dataProviderStringInput
     */
    public function testStringInput(string $line, array $tokes)
    {
        $input = new StringInput($line);
        $this->assertEquals($tokes, $input->getTokens());
    }
}
