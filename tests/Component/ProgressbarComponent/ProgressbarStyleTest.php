<?php

declare(strict_types=1);

namespace Fi1a\Unit\Console\Component\ProgressbarComponent;

use Fi1a\Console\Component\ProgressbarComponent\ProgressbarStyle;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * Стиль
 */
class ProgressbarStyleTest extends TestCase
{
    /**
     * Шаблон
     */
    public function testTemplate(): void
    {
        $style = new ProgressbarStyle();
        $this->assertEquals(
            '{{current}}/{{max}} [{{bar}}] {{percent|sprintf("3s")}}%'
            . '{{if(title)}} {{title}}{{endif}}',
            $style->getTemplate()
        );
        $style->setTemplate('[{{bar}}]');
        $this->assertEquals('[{{bar}}]', $style->getTemplate());
    }

    /**
     * Шаблон по имени
     */
    public function testTemplateByName(): void
    {
        $style = new ProgressbarStyle();
        $this->assertEquals(
            '{{current}}/{{max}} [{{bar}}] {{percent|sprintf("3s")}}%'
            . '{{if(title)}} {{title}}{{endif}}',
            $style->getTemplate()
        );
        $style->setTemplateByName('short');
        $this->assertEquals('[{{bar}}]', $style->getTemplate());
    }

    /**
     * Ширина
     */
    public function testWidth(): void
    {
        $style = new ProgressbarStyle();
        $this->assertEquals(28, $style->getWidth());
        $style->setWidth(40);
        $this->assertEquals(40, $style->getWidth());
    }

    /**
     * Ширина (исключение)
     */
    public function testWidthException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $style = new ProgressbarStyle();
        $style->setWidth(0);
    }

    /**
     * Символ прогрессбара
     */
    public function testCharacter(): void
    {
        $style = new ProgressbarStyle();
        $this->assertEquals('=', $style->getCharacter());
        $style->setCharacter('+');
        $this->assertEquals('+', $style->getCharacter());
    }

    /**
     * Символ прогрессбара (пустое)
     */
    public function testEmptyCharacter(): void
    {
        $style = new ProgressbarStyle();
        $this->assertEquals('-', $style->getEmptyCharacter());
        $style->setEmptyCharacter('+');
        $this->assertEquals('+', $style->getEmptyCharacter());
    }

    /**
     * Символ прогрессбара (пустое)
     */
    public function testProgressCharacter(): void
    {
        $style = new ProgressbarStyle();
        $this->assertEquals('>', $style->getProgressCharacter());
        $style->setProgressCharacter('+');
        $this->assertEquals('+', $style->getProgressCharacter());
    }
}
