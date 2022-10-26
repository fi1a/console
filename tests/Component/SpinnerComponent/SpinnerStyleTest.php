<?php

declare(strict_types=1);

namespace Fi1a\Unit\Console\Component\SpinnerComponent;

use Fi1a\Console\Component\SpinnerComponent\SpinnerStyle;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * Стиль
 */
class SpinnerStyleTest extends TestCase
{
    /**
     * Спиннер
     */
    public function testSpinner(): void
    {
        $style = new SpinnerStyle();
        $this->assertEquals('dots', $style->getSpinner());
        $style->setSpinner('line');
        $this->assertEquals('line', $style->getSpinner());
    }

    /**
     * Спиннер (исключение)
     */
    public function testSpinnerException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $style = new SpinnerStyle();
        $style->setSpinner('unknown');
    }

    /**
     * Шаблон
     */
    public function testTemplate(): void
    {
        $style = new SpinnerStyle();
        $this->assertEquals('{{if(title)}}{{title}} {{endif}}{{spinner}} ', $style->getTemplate());
        $style->setTemplate('{{spinner}}{{if(title)}} {{title}}{{endif}}');
        $this->assertEquals('{{spinner}}{{if(title)}} {{title}}{{endif}}', $style->getTemplate());
    }
}
