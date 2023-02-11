<?php

declare(strict_types=1);

use Fi1a\Console\Component\GroupComponent\GroupComponent;
use Fi1a\Console\Component\GroupComponent\GroupComponentInterface;
use Fi1a\Console\Component\GroupComponent\GroupStyle;
use Fi1a\Console\Component\GroupComponent\GroupStyleInterface;
use Fi1a\Console\Component\ListComponent\CircleListType;
use Fi1a\Console\Component\ListComponent\DecimalLeadingZeroListType;
use Fi1a\Console\Component\ListComponent\DecimalListType;
use Fi1a\Console\Component\ListComponent\DiscListType;
use Fi1a\Console\Component\ListComponent\ListComponent;
use Fi1a\Console\Component\ListComponent\ListComponentInterface;
use Fi1a\Console\Component\ListComponent\ListStyle;
use Fi1a\Console\Component\ListComponent\ListStyleInterface;
use Fi1a\Console\Component\ListComponent\ListTypeRegistry;
use Fi1a\Console\Component\ListComponent\LowerAlphaListType;
use Fi1a\Console\Component\ListComponent\SquareListType;
use Fi1a\Console\Component\ListComponent\UpperAlphaListType;
use Fi1a\Console\Component\PaginationComponent\PaginationComponent;
use Fi1a\Console\Component\PaginationComponent\PaginationComponentInterface;
use Fi1a\Console\Component\PaginationComponent\PaginationStyle;
use Fi1a\Console\Component\PaginationComponent\PaginationStyleInterface;
use Fi1a\Console\Component\PanelComponent\AsciiBorder;
use Fi1a\Console\Component\PanelComponent\BorderRegistry;
use Fi1a\Console\Component\PanelComponent\DoubleBorder;
use Fi1a\Console\Component\PanelComponent\HeavyBorder;
use Fi1a\Console\Component\PanelComponent\HorizontalsBorder;
use Fi1a\Console\Component\PanelComponent\PanelComponent;
use Fi1a\Console\Component\PanelComponent\PanelComponentInterface;
use Fi1a\Console\Component\PanelComponent\PanelStyle;
use Fi1a\Console\Component\PanelComponent\PanelStyleInterface;
use Fi1a\Console\Component\PanelComponent\RoundedBorder;
use Fi1a\Console\Component\ProgressbarComponent\ProgressbarComponent;
use Fi1a\Console\Component\ProgressbarComponent\ProgressbarComponentInterface;
use Fi1a\Console\Component\ProgressbarComponent\ProgressbarStyle;
use Fi1a\Console\Component\ProgressbarComponent\ProgressbarStyleInterface;
use Fi1a\Console\Component\ProgressbarComponent\ProgressbarTemplateRegistry;
use Fi1a\Console\Component\SpinnerComponent\BarSpinner;
use Fi1a\Console\Component\SpinnerComponent\DotsSpinner;
use Fi1a\Console\Component\SpinnerComponent\GrowHorizontalSpinner;
use Fi1a\Console\Component\SpinnerComponent\GrowVerticalSpinner;
use Fi1a\Console\Component\SpinnerComponent\LineSpinner;
use Fi1a\Console\Component\SpinnerComponent\SpinnerComponent;
use Fi1a\Console\Component\SpinnerComponent\SpinnerComponentInterface;
use Fi1a\Console\Component\SpinnerComponent\SpinnerRegistry;
use Fi1a\Console\Component\SpinnerComponent\SpinnerStyle;
use Fi1a\Console\Component\SpinnerComponent\SpinnerStyleInterface;
use Fi1a\Console\Component\TableComponent\AsciiBorder as TableAsciiBorder;
use Fi1a\Console\Component\TableComponent\AsciiCompactBorder;
use Fi1a\Console\Component\TableComponent\BorderRegistry as TableBorderRegistry;
use Fi1a\Console\Component\TableComponent\DoubleBorder as TableDoubleBorder;
use Fi1a\Console\Component\TableComponent\DoubleCompactBorder;
use Fi1a\Console\Component\TableComponent\HeavyBorder as TableHeavyBorder;
use Fi1a\Console\Component\TableComponent\HeavyCompactBorder;
use Fi1a\Console\Component\TableComponent\HorizontalsBorder as TableHorizontalsBorder;
use Fi1a\Console\Component\TableComponent\NoneBorder;
use Fi1a\Console\Component\TableComponent\RoundedBorder as TableRoundedBorder;
use Fi1a\Console\Component\TableComponent\RoundedCompactBorder;
use Fi1a\Console\Component\TableComponent\TableComponent;
use Fi1a\Console\Component\TableComponent\TableComponentInterface;
use Fi1a\Console\Component\TableComponent\TableStyle;
use Fi1a\Console\Component\TableComponent\TableStyleInterface;
use Fi1a\Console\Component\TreeComponent\AsciiLine;
use Fi1a\Console\Component\TreeComponent\DoubleLine;
use Fi1a\Console\Component\TreeComponent\HeavyLine;
use Fi1a\Console\Component\TreeComponent\LineRegistry;
use Fi1a\Console\Component\TreeComponent\NormalLine;
use Fi1a\Console\Component\TreeComponent\TreeComponent;
use Fi1a\Console\Component\TreeComponent\TreeComponentInterface;
use Fi1a\Console\Component\TreeComponent\TreeStyle;
use Fi1a\Console\Component\TreeComponent\TreeStyleInterface;
use Fi1a\Console\IO\ArgvInputArguments;
use Fi1a\Console\IO\ConsoleInput;
use Fi1a\Console\IO\ConsoleOutput;
use Fi1a\Console\IO\ConsoleOutputInterface;
use Fi1a\Console\IO\Formatter;
use Fi1a\Console\IO\FormatterInterface;
use Fi1a\Console\IO\InputArgumentsInterface;
use Fi1a\Console\IO\InputInterface;
use Fi1a\Console\IO\InteractiveInput;
use Fi1a\Console\IO\InteractiveInputInterface;
use Fi1a\Console\IO\Style\ANSIStyle;
use Fi1a\Console\IO\Style\TrueColor;
use Fi1a\Console\IO\Style\TrueColorStyle;
use Fi1a\Console\Registry;
use Fi1a\DI\Builder;

Registry::setArgv($_SERVER['argv'] ?? []);

di()->config()->addDefinition(
    Builder::build(InputArgumentsInterface::class)
        ->defineFactory(function () {
            return new ArgvInputArguments(Registry::getArgv());
        })
    ->getDefinition()
);

di()->config()->addDefinition(
    Builder::build(FormatterInterface::class)
        ->defineClass(Formatter::class)
        ->defineConstructor([ANSIStyle::class])
        ->getDefinition()
);

di()->config()->addDefinition(
    Builder::build(ConsoleOutputInterface::class)
    ->defineClass(ConsoleOutput::class)
    ->getDefinition()
);

di()->config()->addDefinition(
    Builder::build(InputInterface::class)
        ->defineClass(ConsoleInput::class)
        ->getDefinition()
);

di()->config()->addDefinition(
    Builder::build(InteractiveInputInterface::class)
        ->defineClass(InteractiveInput::class)
        ->getDefinition()
);

di()->config()->addDefinition(
    Builder::build(GroupStyleInterface::class)
        ->defineClass(GroupStyle::class)
        ->defineConstructor([50])
        ->getDefinition()
);

di()->config()->addDefinition(
    Builder::build(GroupComponentInterface::class)
        ->defineClass(GroupComponent::class)
        ->getDefinition()
);

di()->config()->addDefinition(
    Builder::build(ListStyleInterface::class)
        ->defineClass(ListStyle::class)
        ->getDefinition()
);

di()->config()->addDefinition(
    Builder::build(ListComponentInterface::class)
        ->defineClass(ListComponent::class)
        ->getDefinition()
);

di()->config()->addDefinition(
    Builder::build(PaginationStyleInterface::class)
        ->defineClass(PaginationStyle::class)
        ->getDefinition()
);

di()->config()->addDefinition(
    Builder::build(PaginationComponentInterface::class)
        ->defineClass(PaginationComponent::class)
        ->getDefinition()
);

di()->config()->addDefinition(
    Builder::build(PanelStyleInterface::class)
        ->defineClass(PanelStyle::class)
        ->getDefinition()
);

di()->config()->addDefinition(
    Builder::build(PanelComponentInterface::class)
        ->defineClass(PanelComponent::class)
        ->getDefinition()
);

di()->config()->addDefinition(
    Builder::build(ProgressbarStyleInterface::class)
        ->defineClass(ProgressbarStyle::class)
        ->getDefinition()
);

di()->config()->addDefinition(
    Builder::build(ProgressbarComponentInterface::class)
        ->defineClass(ProgressbarComponent::class)
        ->getDefinition()
);

di()->config()->addDefinition(
    Builder::build(SpinnerStyleInterface::class)
        ->defineClass(SpinnerStyle::class)
        ->getDefinition()
);

di()->config()->addDefinition(
    Builder::build(SpinnerComponentInterface::class)
        ->defineClass(SpinnerComponent::class)
        ->getDefinition()
);

di()->config()->addDefinition(
    Builder::build(TableStyleInterface::class)
        ->defineClass(TableStyle::class)
        ->getDefinition()
);

di()->config()->addDefinition(
    Builder::build(TableComponentInterface::class)
        ->defineClass(TableComponent::class)
        ->getDefinition()
);

di()->config()->addDefinition(
    Builder::build(TreeStyleInterface::class)
        ->defineClass(TreeStyle::class)
        ->getDefinition()
);

di()->config()->addDefinition(
    Builder::build(TreeComponentInterface::class)
        ->defineClass(TreeComponent::class)
        ->getDefinition()
);

Formatter::addStyle('error', new TrueColorStyle(TrueColor::WHITE, TrueColor::RED));
Formatter::addStyle('success', new TrueColorStyle(TrueColor::BLACK, TrueColor::GREEN));
Formatter::addStyle('info', new TrueColorStyle(TrueColor::GREEN));
Formatter::addStyle('comment', new TrueColorStyle(TrueColor::YELLOW));
Formatter::addStyle('question', new TrueColorStyle(TrueColor::BLACK, TrueColor::CYAN));
Formatter::addStyle('notice', new TrueColorStyle(TrueColor::GRAY));

SpinnerRegistry::add('dots', new DotsSpinner());
SpinnerRegistry::add('line', new LineSpinner());
SpinnerRegistry::add('growVertical', new GrowVerticalSpinner());
SpinnerRegistry::add('growHorizontal', new GrowHorizontalSpinner());
SpinnerRegistry::add('bar', new BarSpinner());

ProgressbarTemplateRegistry::add('short', '[{{bar}}]');
ProgressbarTemplateRegistry::add(
    'normal',
    '{{current}}/{{max}} [{{bar}}] {{percent|sprintf("3s")}}%{{if(title)}} {{title}}{{endif}}'
);
ProgressbarTemplateRegistry::add(
    'time',
    '[{{bar}}] {{elapsed|sprintf("10s")}} / {{remaining|sprintf("-10s")}}{{if(title)}} {{title}}{{endif}}'
);
ProgressbarTemplateRegistry::add(
    'memory',
    '[{{bar}}] {{memory|memory}}{{if(title)}} {{title}}{{endif}}'
);
ProgressbarTemplateRegistry::add(
    'full',
    '{{current}}/{{max}} [{{bar}}] {{percent|sprintf("3s")}}% '
    . '{{elapsed|sprintf("10s")}} / {{remaining|sprintf("-10s")}}'
    . ' {{memory|memory}}{{if(title)}} {{title}}{{endif}}'
);

TableBorderRegistry::add('none', new NoneBorder());
TableBorderRegistry::add('ascii', new TableAsciiBorder());
TableBorderRegistry::add('ascii_compact', new AsciiCompactBorder());
TableBorderRegistry::add('double', new TableDoubleBorder());
TableBorderRegistry::add('double_compact', new DoubleCompactBorder());
TableBorderRegistry::add('heavy', new TableHeavyBorder());
TableBorderRegistry::add('heavy_compact', new HeavyCompactBorder());
TableBorderRegistry::add('horizontals', new TableHorizontalsBorder());
TableBorderRegistry::add('rounded', new TableRoundedBorder());
TableBorderRegistry::add('rounded_compact', new RoundedCompactBorder());

BorderRegistry::add('ascii', new AsciiBorder());
BorderRegistry::add('double', new DoubleBorder());
BorderRegistry::add('heavy', new HeavyBorder());
BorderRegistry::add('horizontals', new HorizontalsBorder());
BorderRegistry::add('rounded', new RoundedBorder());

ListTypeRegistry::add('upper-alpha', new UpperAlphaListType());
ListTypeRegistry::add('square', new SquareListType());
ListTypeRegistry::add('lower-alpha', new LowerAlphaListType());
ListTypeRegistry::add('decimal-leading-zero', new DecimalLeadingZeroListType());
ListTypeRegistry::add('decimal', new DecimalListType());
ListTypeRegistry::add('circle', new CircleListType());
ListTypeRegistry::add('disc', new DiscListType());

LineRegistry::add('normal', new NormalLine());
LineRegistry::add('double', new DoubleLine());
LineRegistry::add('heavy', new HeavyLine());
LineRegistry::add('ascii', new AsciiLine());
