<?php

declare(strict_types=1);

namespace Fi1a\Console\Examples\Command;

use Fi1a\Console\AbstractCommand;
use Fi1a\Console\AppInterface;
use Fi1a\Console\Component\GroupComponent\GroupComponent;
use Fi1a\Console\Component\GroupComponent\GroupStyle;
use Fi1a\Console\Component\ListComponent\ListComponent;
use Fi1a\Console\Component\ListComponent\ListStyle;
use Fi1a\Console\Component\PanelComponent\PanelComponent;
use Fi1a\Console\Component\PanelComponent\PanelStyle;
use Fi1a\Console\Component\PanelComponent\PanelStyleInterface;
use Fi1a\Console\Definition\DefinitionInterface;
use Fi1a\Console\IO\ConsoleOutputInterface;
use Fi1a\Console\IO\InputArgumentsInterface;
use Fi1a\Console\IO\InputInterface;
use Fi1a\Console\IO\Style\ColorInterface;

/**
 * Списки
 */
class ListCommand extends AbstractCommand
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
            '<option=bold>Списки</>',
            $panelStyleTitle
        );
        $panelTitle->display();
        $output->writeln('');

        $groupStyle = new GroupStyle(45);
        $group1 = new GroupComponent($output, $groupStyle);

        $panelStyle = new PanelStyle();

        $listStyleUpperAlpha = new ListStyle();
        $listStyleUpperAlpha->setType('upper-alpha')
            ->setMarkerColor(ColorInterface::GREEN);

        $listUpperAlpha = new ListComponent($output, $listStyleUpperAlpha);

        $listUpperAlpha->addItem('Lorem ipsum dolor sit amet');
        $listUpperAlpha->addItem('Consectetur adipiscing elit');
        $listUpperAlpha->addItem('Sed do eiusmod tempor incididunt');
        $listUpperAlpha->addItem('Duis aute irure dolor in reprehenderit');
        $listUpperAlpha->addItem('Reprehenderit in voluptate velit');

        $listStyleSquare = new ListStyle();
        $listStyleSquare->setType('square')
            ->setMarkerColor(ColorInterface::YELLOW);

        $listSquare = new ListComponent($output, $listStyleSquare);

        $listSquare->addItem('Lorem ipsum dolor sit amet');
        $listSquare->addItem('Consectetur adipiscing elit');
        $listSquare->addItem('Sed do eiusmod tempor incididunt');
        $listSquare->addItem('Duis aute irure dolor in reprehenderit');
        $listSquare->addItem('Reprehenderit in voluptate velit');

        $listStyleLowerAlpha = new ListStyle();
        $listStyleLowerAlpha->setType('lower-alpha')
            ->setMarkerColor(ColorInterface::RED);

        $listLowerAlpha = new ListComponent($output, $listStyleLowerAlpha);

        $listLowerAlpha->addItem('Lorem ipsum dolor sit amet');
        $listLowerAlpha->addItem('Consectetur adipiscing elit');
        $listLowerAlpha->addItem('Sed do eiusmod tempor incididunt');
        $listLowerAlpha->addItem('Duis aute irure dolor in reprehenderit');
        $listLowerAlpha->addItem('Reprehenderit in voluptate velit');

        $panel1 = new PanelComponent(
            $output,
            $listUpperAlpha,
            $panelStyle
        );
        $panel2 = new PanelComponent(
            $output,
            $listSquare,
            $panelStyle
        );
        $panel3 = new PanelComponent(
            $output,
            $listLowerAlpha,
            $panelStyle
        );

        $group1->addPanel($panel1);
        $group1->addPanel($panel2);
        $group1->addPanel($panel3);

        $group1->display();
        $output->writeln(['', '']);

        $group2 = new GroupComponent($output, $groupStyle);

        $listStyleDecimalLeadingZero = new ListStyle();
        $listStyleDecimalLeadingZero->setType('decimal-leading-zero')
            ->setMarkerColor(ColorInterface::BLUE);

        $listDecimalLeadingZero = new ListComponent($output, $listStyleDecimalLeadingZero);

        $listDecimalLeadingZero->addItem('Lorem ipsum dolor sit amet');
        $listDecimalLeadingZero->addItem('Consectetur adipiscing elit');
        $listDecimalLeadingZero->addItem('Sed do eiusmod tempor incididunt');
        $listDecimalLeadingZero->addItem('Duis aute irure dolor in reprehenderit');
        $listDecimalLeadingZero->addItem('Reprehenderit in voluptate velit');

        $panel4 = new PanelComponent(
            $output,
            $listDecimalLeadingZero,
            $panelStyle
        );

        $listStyleDecimal = new ListStyle();
        $listStyleDecimal->setType('decimal')
            ->setMarkerColor(ColorInterface::CYAN);

        $listDecimal = new ListComponent($output, $listStyleDecimal);

        $listDecimal->addItem('Lorem ipsum dolor sit amet');
        $listDecimal->addItem('Consectetur adipiscing elit');
        $listDecimal->addItem('Sed do eiusmod tempor incididunt');
        $listDecimal->addItem('Duis aute irure dolor in reprehenderit');
        $listDecimal->addItem('Reprehenderit in voluptate velit');

        $panel5 = new PanelComponent(
            $output,
            $listDecimal,
            $panelStyle
        );

        $listStyleCircle = new ListStyle();
        $listStyleCircle->setType('circle')
            ->setMarkerColor(ColorInterface::GRAY);

        $listCircle = new ListComponent($output, $listStyleCircle);

        $listCircle->addItem('Lorem ipsum dolor sit amet');
        $listCircle->addItem('Consectetur adipiscing elit');
        $listCircle->addItem('Sed do eiusmod tempor incididunt');
        $listCircle->addItem('Duis aute irure dolor in reprehenderit');
        $listCircle->addItem('Reprehenderit in voluptate velit');

        $panel6 = new PanelComponent(
            $output,
            $listCircle,
            $panelStyle
        );

        $group2->addPanel($panel4);
        $group2->addPanel($panel5);
        $group2->addPanel($panel6);

        $group2->display();
        $output->writeln(['', '']);

        $group3 = new GroupComponent($output, $groupStyle);

        $listStyleDisc = new ListStyle();
        $listStyleDisc->setType('disc')
            ->setMarkerColor(ColorInterface::WHITE);

        $listDisc = new ListComponent($output, $listStyleDisc);

        $listDisc->addItem('Lorem ipsum dolor sit amet');
        $listDisc->addItem('Consectetur adipiscing elit');
        $listDisc->addItem('Sed do eiusmod tempor incididunt');
        $listDisc->addItem('Duis aute irure dolor in reprehenderit');
        $listDisc->addItem('Reprehenderit in voluptate velit');

        $panel7 = new PanelComponent(
            $output,
            $listDisc,
            $panelStyle
        );

        $group3->addPanel($panel7);
        $group3->display();

        $output->writeln('');

        return 0;
    }

    /**
     * @inheritDoc
     */
    public function description(): ?string
    {
        return 'Списки';
    }
}
