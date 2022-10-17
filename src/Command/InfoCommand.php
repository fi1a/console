<?php

declare(strict_types=1);

namespace Fi1a\Console\Command;

use Fi1a\Console\AbstractCommand;
use Fi1a\Console\AppInterface;
use Fi1a\Console\CommandInterface;
use Fi1a\Console\Definition\Definition;
use Fi1a\Console\Definition\DefinitionInterface;
use Fi1a\Console\IO\ConsoleOutputInterface;
use Fi1a\Console\IO\InputArgumentsInterface;
use Fi1a\Console\IO\InputInterface;

/**
 * Команда info
 */
class InfoCommand extends AbstractCommand
{
    /**
     * @inheritDoc
     */
    public function __construct(DefinitionInterface $definition)
    {
    }

    /**
     * @inheritDoc
     */
    public function run(
        InputArgumentsInterface $input,
        ConsoleOutputInterface $output,
        InputInterface $stream,
        DefinitionInterface $definition,
        AppInterface $app
    ): int {
        $commands = $app->allCommands();
        /**
         * @var string[] $commandNames
         */
        $commandNames = array_keys($commands);
        uasort($commandNames, function (string $a, string $b) {
            return strcmp($a, $b);
        });
        $output->writeln('<info>Команды:</info>');
        $output->writeln();
        foreach ($commandNames as $name) {
            $command = $commands[$name];
            $definition = new Definition();
            /**
             * @var CommandInterface $instance
             * @psalm-suppress InvalidStringClass
             */
            $instance = new $command($definition);
            $output->writeln('<comment>{{name}}</comment>{{if(info)}} - {{info}}{{endif}}', [
                'name' => $name,
                'info' => $instance->info(),
            ]);
        }

        $output->writeln();
        $output->writeln('<info>Опции:</info>');
        $output->writeln();
        $output->writeln('<comment>--colors, -c (ansi|ext|trueColor)</comment> - используемый цвет консоли');
        $output->writeln(
            '<comment>--verbose, -v (none, normal, hight, hightest, debug)</comment>'
            . ' - определяет уровень подробности вывода сообщений при работе консольных команда'
        );
        $output->writeln('<comment>--help, -h</comment> - справка по выбранной команде');

        return 0;
    }

    /**
     * @inheritDoc
     */
    public function info(): string
    {
        return 'список доступных команд и опций';
    }
}
