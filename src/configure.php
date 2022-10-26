<?php

declare(strict_types=1);

use Fi1a\Console\Component\SpinnerComponent\DotsSpinner;
use Fi1a\Console\Component\SpinnerComponent\LineSpinner;
use Fi1a\Console\Component\SpinnerComponent\SpinnerCollection;
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

SpinnerCollection::add('dots', new DotsSpinner());
SpinnerCollection::add('line', new LineSpinner());
