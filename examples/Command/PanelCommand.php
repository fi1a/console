<?php

declare(strict_types=1);

namespace Fi1a\Console\Examples\Command;

use Fi1a\Console\AbstractCommand;
use Fi1a\Console\AppInterface;
use Fi1a\Console\Component\PanelComponent\PanelComponent;
use Fi1a\Console\Component\PanelComponent\PanelStyle;
use Fi1a\Console\Component\PanelComponent\PanelStyleInterface;
use Fi1a\Console\Definition\DefinitionInterface;
use Fi1a\Console\IO\ConsoleOutputInterface;
use Fi1a\Console\IO\InputArgumentsInterface;
use Fi1a\Console\IO\InputInterface;
use Fi1a\Console\IO\Style\ColorInterface;

/**
 * Компонент панели
 */
class PanelCommand extends AbstractCommand
{
    /**
     * @inheritDoc
     */
    public function __construct(DefinitionInterface $definition)
    {
    }

    /**
     * @inheritDoc
     * @psalm-suppress PossiblyFalseReference
     * @psalm-suppress MixedMethodCall
     */
    public function run(
        InputArgumentsInterface $input,
        ConsoleOutputInterface $output,
        InputInterface $stream,
        DefinitionInterface $definition,
        AppInterface $app
    ): int {
        $output->writeln(['', '<option=bold>Компонент панели</>', '']);

        $output->writeln(['', '#1', '']);
        $panelStyle1 = new PanelStyle();

        $panelStyle1->setWidth(40)
            ->setPadding(1)
            ->setBorder('heavy')
            ->setBackgroundColor(ColorInterface::YELLOW)
            ->setBorderColor(ColorInterface::RED)
            ->setColor(ColorInterface::BLACK)
            ->setAlign(PanelStyleInterface::ALIGN_CENTER);

        $panel1 = new PanelComponent(
            $output,
            'Lorem ipsum dolor sit amet, <error>consectetur adipiscing elit</error>, '
            . 'sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            $panelStyle1
        );

        $panel1->display();

        $output->writeln(['', '#2', '']);

        $panelStyle2 = new PanelStyle();

        $panelStyle2->setWidth(40)
            ->setPadding(1)
            ->setBackgroundColor(ColorInterface::GREEN)
            ->setBorderColor(ColorInterface::WHITE)
            ->setColor(ColorInterface::GRAY)
            ->setAlign(PanelStyleInterface::ALIGN_CENTER);

        $panel2 = new PanelComponent(
            $output,
            'No errors found!',
            $panelStyle2
        );

        $panel2->display();

        $output->writeln(['', '#3', '']);

        $panelStyle3 = new PanelStyle();
        $panelStyle3->setWidth(40)
            ->setPadding(1)
            ->setBorder('double')
            ->setBorderColor(ColorInterface::WHITE)
            ->setColor(ColorInterface::WHITE);

        $panel3 = new PanelComponent(
            $output,
            ['Before text', $panel2, 'After text'],
            $panelStyle3
        );
        $panel3->display();

        $output->writeln('');

        return 0;
    }

    /**
     * @inheritDoc
     */
    public function description(): ?string
    {
        return 'Компонент панели';
    }
}
