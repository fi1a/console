<?php

declare(strict_types=1);

namespace Fi1a\Unit\Console\Definition;

use Fi1a\Console\Definition\Validation;
use Fi1a\Validation\AllOf;
use Fi1a\Validation\OneOf;
use PHPUnit\Framework\TestCase;

/**
 * Валидация аргументов и опций
 */
class ValidationTest extends TestCase
{
    /**
     * Все правила должны удовлетворять условию
     */
    public function testAllOf(): void
    {
        $validation = new Validation();
        $this->assertNull($validation->getChain());
        $this->assertInstanceOf(AllOf::class, $validation->allOf());
        $this->assertInstanceOf(AllOf::class, $validation->getChain());
    }

    /**
     * Все правила должны удовлетворять условию
     */
    public function testOneOf(): void
    {
        $validation = new Validation();
        $this->assertNull($validation->getChain());
        $this->assertInstanceOf(OneOf::class, $validation->oneOf());
        $this->assertInstanceOf(OneOf::class, $validation->getChain());
    }
}
