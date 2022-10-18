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
        $output->writeln();
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
            $output->writeln($name, [], 'comment');
            $description = $instance->description();
            if ($description) {
                $output->writeln($description);
                $output->writeln();
            }
        }

        $output->writeln('<info>Опции:</info>');
        $output->writeln();

        $output->writeln('<comment>--colors, -c</comment>');
        $output->writeln('Используемый цвет в консоли.');
        $output->writeln('Возможные значения: none, ansi, ext, trueColor.');
        $output->writeln();

        $output->writeln('<comment>--verbose, -v</comment>');
        $output->writeln('Определяет уровень подробности вывода сообщений при работе консольных команд.');
        $output->writeln('Возможные значения: none, normal, hight, hightest, debug.');
        $output->writeln();

        $output->writeln('<comment>--help, -h</comment>');
        $output->writeln('Справка по выбранной команде.');
        $output->writeln();

        return 0;
    }

    /**
     * @inheritDoc
     */
    public function description(): ?string
    {
        return 'Список доступных команд и опций.';
    }
}
