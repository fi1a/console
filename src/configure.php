<?php

declare(strict_types=1);

use Fi1a\Console\IO\Formatter;
use Fi1a\Console\IO\Style\ANSIColor;
use Fi1a\Console\IO\Style\ANSIStyle;

Formatter::addStyle('error', new ANSIStyle(ANSIColor::WHITE, ANSIColor::RED));
Formatter::addStyle('success', new ANSIStyle(ANSIColor::BLACK, ANSIColor::GREEN));
Formatter::addStyle('info', new ANSIStyle(ANSIColor::GREEN));
Formatter::addStyle('comment', new ANSIStyle(ANSIColor::YELLOW));
Formatter::addStyle('question', new ANSIStyle(ANSIColor::BLACK, ANSIColor::CYAN));
