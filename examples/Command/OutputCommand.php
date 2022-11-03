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
 * Форматированный вывод в консоль
 */
class OutputCommand extends AbstractCommand
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
            '<option=bold>Форматированный вывод в консоль</>',
            $panelStyleTitle
        );
        $panelTitle->display();
        $output->writeln('');

        $groupStyle = new GroupStyle(40);
        $group = new GroupComponent($output, $groupStyle);

        $panelStyle = new PanelStyle();
        $panelStyle->setBorder('heavy')
            ->setPadding(1);

        $panel1 = new PanelComponent(
            $output,
            'Lorem ipsum dolor sit amet, <error>consectetur adipiscing elit</error>, '
            . 'sed do eiusmod tempor incididunt ut '
            . 'labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris '
            . 'nisi ut aliquip ex ea commodo consequat. <success>Duis aute irure dolor in reprehenderit</success> '
            . 'in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat '
            . 'non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            $panelStyle
        );
        $panel2 = new PanelComponent(
            $output,
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut '
            . 'labore et dolore magna aliqua. <bg=red>Ut enim ad <color=green>minim veniam, <option=bold>quis '
            . 'nostrud</> exercitation</> ullamco laboris</> '
            . 'nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit '
            . 'esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in '
            . 'culpa qui officia deserunt mollit anim id est laborum.',
            $panelStyle
        );
        $panel3 = new PanelComponent(
            $output,
            'Lorem ipsum <option=bold>dolor sit amet</>, consectetur <option=blink>adipiscing elit</>, sed '
            . 'do <option=conceal>eiusmod tempor</> incididunt ut '
            . 'labore <option=reverse>et dolore magna</> aliqua. <option=underscore>Ut enim ad</> minim veniam, '
            . 'quis nostrud exercitation ullamco laboris '
            . 'nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit '
            . 'esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in '
            . 'culpa qui officia deserunt mollit anim id est laborum.',
            $panelStyle
        );

        $group->addPanel($panel1);
        $group->addPanel($panel2);
        $group->addPanel($panel3);

        $group->display();

        $output->writeln('');

        return 0;
    }

    /**
     * @inheritDoc
     */
    public function description(): ?string
    {
        return 'Форматированный вывод в консоль';
    }
}
