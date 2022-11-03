<?php

declare(strict_types=1);

namespace Fi1a\Console\Examples\Command;

use Fi1a\Console\AbstractCommand;
use Fi1a\Console\AppInterface;
use Fi1a\Console\Component\GroupComponent\GroupComponent;
use Fi1a\Console\Component\GroupComponent\GroupStyle;
use Fi1a\Console\Component\PanelComponent\PanelComponent;
use Fi1a\Console\Component\PanelComponent\PanelStyle;
use Fi1a\Console\Component\PanelComponent\PanelStyleInterface;
use Fi1a\Console\Definition\DefinitionInterface;
use Fi1a\Console\IO\ConsoleOutputInterface;
use Fi1a\Console\IO\InputArgumentsInterface;
use Fi1a\Console\IO\InputInterface;

/**
 * Стили границ панелей
 */
class PanelBordersCommand extends AbstractCommand
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
        $output->writeln('');
        $panelStyleTitle = new PanelStyle();
        $panelStyleTitle->setWidth(120)
            ->setAlign(PanelStyleInterface::ALIGN_CENTER);
        $panelTitle = new PanelComponent(
            $output,
            '<option=bold>Стили границ панелей</>',
            $panelStyleTitle
        );
        $panelTitle->display();
        $output->writeln('');

        $groupStyle = new GroupStyle(40);
        $groupStyle->setHeight(5)
            ->setPanelSpacing(2);
        $group1 = new GroupComponent($output, $groupStyle);

        $panelStyleAscii = new PanelStyle();
        $panelStyleAscii->setBorder('ascii')
            ->setPadding(1);

        $panelStyleDouble = new PanelStyle();
        $panelStyleDouble->setBorder('double')
            ->setPadding(1);

        $panelStyleHeavy = new PanelStyle();
        $panelStyleHeavy->setBorder('heavy')
            ->setPadding(1);

        $panelAscii = new PanelComponent(
            $output,
            'ascii',
            $panelStyleAscii
        );
        $panelDouble = new PanelComponent(
            $output,
            'double',
            $panelStyleDouble
        );
        $panelHeavy = new PanelComponent(
            $output,
            'heavy',
            $panelStyleHeavy
        );

        $group1->addPanel($panelAscii);
        $group1->addPanel($panelDouble);
        $group1->addPanel($panelHeavy);

        $group1->display();

        $panelStyleHorizontals = new PanelStyle();
        $panelStyleHorizontals->setBorder('horizontals')
            ->setPadding(1);

        $panelStyleRounded = new PanelStyle();
        $panelStyleRounded->setBorder('rounded')
            ->setPadding(1);

        $panelHorizontals = new PanelComponent(
            $output,
            'horizontals',
            $panelStyleHorizontals
        );

        $panelRounded = new PanelComponent(
            $output,
            'rounded',
            $panelStyleRounded
        );

        $group2 = new GroupComponent($output, $groupStyle);

        $group2->addPanel($panelHorizontals);
        $group2->addPanel($panelRounded);

        $group2->display();

        $output->writeln('');

        return 0;
    }

    /**
     * @inheritDoc
     */
    public function description(): ?string
    {
        return 'Стили границ панелей';
    }
}
