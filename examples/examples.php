<?php

declare(strict_types=1);

use Fi1a\Console\App;
use Fi1a\Console\Examples\Command\ColorsCommand;
use Fi1a\Console\Examples\Command\GroupCommand;
use Fi1a\Console\Examples\Command\InteractiveCommand;
use Fi1a\Console\Examples\Command\ListCommand;
use Fi1a\Console\Examples\Command\OutputCommand;
use Fi1a\Console\Examples\Command\PaginationCommand;
use Fi1a\Console\Examples\Command\PanelBordersCommand;
use Fi1a\Console\Examples\Command\PanelCommand;
use Fi1a\Console\Examples\Command\ProgressbarCommand;
use Fi1a\Console\Examples\Command\SpinnerCommand;

require_once __DIR__ . '/../vendor/autoload.php';

$code = (new App())
    ->addCommand('colors', ColorsCommand::class)
    ->addCommand('output', OutputCommand::class)
    ->addCommand('interactive', InteractiveCommand::class)
    ->addCommand('panel', PanelCommand::class)
    ->addCommand('panel-borders', PanelBordersCommand::class)
    ->addCommand('group', GroupCommand::class)
    ->addCommand('list', ListCommand::class)
    ->addCommand('pagination', PaginationCommand::class)
    ->addCommand('progressbar', ProgressbarCommand::class)
    ->addCommand('spinner', SpinnerCommand::class)
    ->run();
exit($code);
