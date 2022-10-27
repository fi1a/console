<?php

declare(strict_types=1);

use Fi1a\Console\Component\ProgressbarComponent\ProgressbarTemplateRegistry;
use Fi1a\Console\Component\SpinnerComponent\BarSpinner;
use Fi1a\Console\Component\SpinnerComponent\DotsSpinner;
use Fi1a\Console\Component\SpinnerComponent\GrowHorizontalSpinner;
use Fi1a\Console\Component\SpinnerComponent\GrowVerticalSpinner;
use Fi1a\Console\Component\SpinnerComponent\LineSpinner;
use Fi1a\Console\Component\SpinnerComponent\SpinnerRegistry;
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
