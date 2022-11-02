<?php

declare(strict_types=1);

use Fi1a\Console\App;
use Fi1a\Console\Examples\Command\ColorsCommand;

require_once __DIR__ . '/../vendor/autoload.php';

$code = (new App())
    ->addCommand('colors', ColorsCommand::class)
    ->run();
exit($code);
