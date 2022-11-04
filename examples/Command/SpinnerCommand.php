<?php

declare(strict_types=1);

namespace Fi1a\Console\Examples\Command;

use Fi1a\Console\AbstractCommand;
use Fi1a\Console\AppInterface;
use Fi1a\Console\Component\SpinnerComponent\SpinnerComponent;
use Fi1a\Console\Component\SpinnerComponent\SpinnerStyle;
use Fi1a\Console\Definition\DefinitionInterface;
use Fi1a\Console\IO\ConsoleOutputInterface;
use Fi1a\Console\IO\InputArgumentsInterface;
use Fi1a\Console\IO\InputInterface;

/**
 * Spinner
 */
class SpinnerCommand extends AbstractCommand
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
        $output->writeln(['', '<option=bold>Spinner</>', '']);

        $spinnerStyle = new SpinnerStyle();
        $spinnerStyle->setTemplate('{{if(title)}}{{title}} {{endif}}<color=green>{{spinner}}</> ');

        $spinner = new SpinnerComponent($output, $spinnerStyle);

        $index = 0;
        do {
            if ($index % 1000000 === 0) {
                $title = $spinner->getTitle();
                if ($title) {
                    $spinner->clear();
                    $output->writeln($title);
                }
                $spinner->setTitle('In progress (' . $index . ')');
            }

            $spinner->display();
            $index++;
        } while ($index < 10000000);
        $output->writeln('');

        return 0;
    }

    /**
     * @inheritDoc
     */
    public function description(): ?string
    {
        return 'Spinner';
    }
}
