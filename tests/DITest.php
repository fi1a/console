<?php

declare(strict_types=1);

namespace Fi1a\Unit\Console;

use Fi1a\Console\Component\GroupComponent\GroupComponentInterface;
use Fi1a\Console\Component\ListComponent\ListComponentInterface;
use Fi1a\Console\Component\PaginationComponent\PaginationComponentInterface;
use Fi1a\Console\Component\PanelComponent\PanelComponentInterface;
use Fi1a\Console\Component\ProgressbarComponent\ProgressbarComponentInterface;
use Fi1a\Console\Component\SpinnerComponent\SpinnerComponentInterface;
use Fi1a\Console\Component\TableComponent\TableComponentInterface;
use Fi1a\Console\Component\TreeComponent\TreeComponentInterface;
use Fi1a\Console\IO\ConsoleOutputInterface;
use Fi1a\Console\IO\FormatterInterface;
use Fi1a\Console\IO\InputArgumentsInterface;
use Fi1a\Console\IO\InputInterface;
use Fi1a\Console\IO\InteractiveInputInterface;
use PHPUnit\Framework\TestCase;

/**
 * Dependency injection definition
 */
class DITest extends TestCase
{
    /**
     * Создание InputArgumentsInterface
     */
    public function testInputArguments(): void
    {
        $this->assertInstanceOf(
            InputArgumentsInterface::class,
            di()->get(InputArgumentsInterface::class)
        );
    }

    /**
     * Создание FormatterInterface
     */
    public function testFormatter(): void
    {
        $this->assertInstanceOf(
            FormatterInterface::class,
            di()->get(FormatterInterface::class)
        );
    }

    /**
     * Создание ConsoleOutputInterface
     */
    public function testConsoleOutput(): void
    {
        $this->assertInstanceOf(
            ConsoleOutputInterface::class,
            di()->get(ConsoleOutputInterface::class)
        );
    }

    /**
     * Создание InputInterface
     */
    public function testInput(): void
    {
        $this->assertInstanceOf(
            InputInterface::class,
            di()->get(InputInterface::class)
        );
    }

    /**
     * Создание GroupComponentInterface
     */
    public function testGroupComponent(): void
    {
        $this->assertInstanceOf(
            GroupComponentInterface::class,
            di()->get(GroupComponentInterface::class)
        );
    }

    /**
     * Создание ListComponentInterface
     */
    public function testListComponent(): void
    {
        $this->assertInstanceOf(
            ListComponentInterface::class,
            di()->get(ListComponentInterface::class)
        );
    }

    /**
     * Создание PaginationComponentInterface
     */
    public function testPaginationComponent(): void
    {
        $this->assertInstanceOf(
            PaginationComponentInterface::class,
            di()->get(PaginationComponentInterface::class)
        );
    }

    /**
     * Создание PanelComponentInterface
     */
    public function testPanelComponent(): void
    {
        $this->assertInstanceOf(
            PanelComponentInterface::class,
            di()->get(PanelComponentInterface::class)
        );
    }

    /**
     * Создание ProgressbarComponentInterface
     */
    public function testProgressbarComponent(): void
    {
        $this->assertInstanceOf(
            ProgressbarComponentInterface::class,
            di()->get(ProgressbarComponentInterface::class)
        );
    }

    /**
     * Создание SpinnerComponentInterface
     */
    public function testSpinnerComponent(): void
    {
        $this->assertInstanceOf(
            SpinnerComponentInterface::class,
            di()->get(SpinnerComponentInterface::class)
        );
    }

    /**
     * Создание TableComponentInterface
     */
    public function testTableComponent(): void
    {
        $this->assertInstanceOf(
            TableComponentInterface::class,
            di()->get(TableComponentInterface::class)
        );
    }

    /**
     * Создание TreeComponentInterface
     */
    public function testTreeComponent(): void
    {
        $this->assertInstanceOf(
            TreeComponentInterface::class,
            di()->get(TreeComponentInterface::class)
        );
    }

    /**
     * Создание InteractiveInputInterface
     */
    public function testInteractiveInput(): void
    {
        $this->assertInstanceOf(
            InteractiveInputInterface::class,
            di()->get(InteractiveInputInterface::class)
        );
    }
}
