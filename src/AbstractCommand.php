<?php

declare(strict_types=1);

namespace Fi1a\Console;

use Fi1a\Console\Definition\Argument;
use Fi1a\Console\Definition\DefinitionInterface;
use Fi1a\Console\Definition\Option;
use Fi1a\Console\IO\ConsoleOutputInterface;
use Fi1a\Console\IO\InputArgumentsInterface;
use Fi1a\Console\IO\InputInterface;

/**
 * Команда
 */
abstract class AbstractCommand implements CommandInterface
{
    /**
     * @inheritDoc
     */
    public function description(): ?string
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function help(
        InputArgumentsInterface $input,
        ConsoleOutputInterface $output,
        InputInterface $stream,
        DefinitionInterface $definition,
        AppInterface $app,
        ?string $commandName
    ): int {
        $output->writeln();
        $output->writeln(
            'Справка по команде{{if(name)}} {{name}}{{endif}}',
            ['name' => $commandName,],
            'info'
        );
        $output->writeln();
        $description = $this->description();
        if ($description) {
            $output->writeln('Описание:');
            $output->writeln($description);
            $output->writeln();
        }

        $arguments = [];
        foreach ($definition->allArguments() as $name => $argument) {
            $arguments[] = [
                'full' => $name,
                'instance' => $argument,
            ];
        }

        if (count($arguments)) {
            uasort($arguments, function (array $a, array $b) {
                return strcmp((string) $a['full'], (string) $b['full']);
            });

            $output->writeln('Аргументы:', [], 'info');
            $output->writeln();

            foreach ($arguments as $item) {
                $output->writeln((string) $item['full'], [], 'comment');
                $argument = $item['instance'];
                assert($argument instanceof Argument);
                $description = $argument->getDescription();
                if ($description) {
                    $output->writeln($description);
                }
                $output->writeln();
            }
        }

        $options = [];
        foreach ($definition->allOptions() as $name => $option) {
            $options[] = [
                'full' => $name,
                'short' => null,
                'instance' => $option,
            ];
        }
        foreach ($definition->allShortOptions() as $name => $option) {
            foreach ($options as $index => $item) {
                if ($item['instance'] !== $option) {
                    continue;
                }

                $options[$index]['short'] = $name;
            }
        }

        if (count($options)) {
            uasort($options, function (array $a, array $b) {
                return strcmp((string) $a['full'], (string) $b['full']);
            });

            $output->writeln('Опции:', [], 'info');
            $output->writeln();

            foreach ($options as $item) {
                $output->writeln(
                    '--{{full}}{{if(short)}}, -{{short}}{{endif}}',
                    [
                        'full' => $item['full'],
                        'short' => $item['short'],
                    ],
                    'comment'
                );
                $option = $item['instance'];
                assert($option instanceof Option);
                $description = $option->getDescription();
                if ($description) {
                    $output->writeln($description);
                }
                $output->writeln();
            }
        }

        return 0;
    }
}
