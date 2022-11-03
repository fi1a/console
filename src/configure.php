<?php

declare(strict_types=1);

use Fi1a\Console\Component\ListComponent\CircleListType;
use Fi1a\Console\Component\ListComponent\DecimalLeadingZeroListType;
use Fi1a\Console\Component\ListComponent\DecimalListType;
use Fi1a\Console\Component\ListComponent\DiscListType;
use Fi1a\Console\Component\ListComponent\ListTypeRegistry;
use Fi1a\Console\Component\ListComponent\LowerAlphaListType;
use Fi1a\Console\Component\ListComponent\SquareListType;
use Fi1a\Console\Component\ListComponent\UpperAlphaListType;
use Fi1a\Console\Component\PanelComponent\AsciiBorder;
use Fi1a\Console\Component\PanelComponent\BorderRegistry;
use Fi1a\Console\Component\PanelComponent\DoubleBorder;
use Fi1a\Console\Component\PanelComponent\HeavyBorder;
use Fi1a\Console\Component\PanelComponent\HorizontalsBorder;
use Fi1a\Console\Component\PanelComponent\RoundedBorder;
use Fi1a\Console\Component\ProgressbarComponent\ProgressbarTemplateRegistry;
use Fi1a\Console\Component\SpinnerComponent\BarSpinner;
use Fi1a\Console\Component\SpinnerComponent\DotsSpinner;
use Fi1a\Console\Component\SpinnerComponent\GrowHorizontalSpinner;
use Fi1a\Console\Component\SpinnerComponent\GrowVerticalSpinner;
use Fi1a\Console\Component\SpinnerComponent\LineSpinner;
use Fi1a\Console\Component\SpinnerComponent\SpinnerRegistry;
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
use Fi1a\Console\IO\Formatter;
use Fi1a\Console\IO\Style\TrueColor;
use Fi1a\Console\IO\Style\TrueColorStyle;
use Fi1a\Console\Registry;

Registry::setArgv($_SERVER['argv'] ?? []);

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
