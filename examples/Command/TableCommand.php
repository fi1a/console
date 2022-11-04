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
use Fi1a\Console\Component\TableComponent\TableComponent;
use Fi1a\Console\Component\TableComponent\TableStyle;
use Fi1a\Console\Definition\DefinitionInterface;
use Fi1a\Console\IO\ConsoleOutputInterface;
use Fi1a\Console\IO\InputArgumentsInterface;
use Fi1a\Console\IO\InputInterface;

/**
 * Табличное отображение
 */
class TableCommand extends AbstractCommand
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
            '<option=bold>Табличное отображение</>',
            $panelStyleTitle
        );
        $panelTitle->display();
        $output->writeln('');

        $headers = ['Товар', 'Стоимость', 'Количество', 'Итоговая сумма'];
        $rows = [
            ['Смартфон', '1000', '2', '2000'],
            ['Шкаф', '500', '1', '500'],
        ];

        $panelStyle = new PanelStyle();

        $groupStyle = new GroupStyle(50);
        $groupStyle->setPanelSpacing(4);
        $group = new GroupComponent($output, $groupStyle);

        $tableStyleAscii = new TableStyle();
        $tableStyleAscii->setBorder('ascii')
            ->setWidth(50);

        $tableAscii = new TableComponent($output, $tableStyleAscii);
        $tableAscii->setHeaders($headers);
        $tableAscii->setRows($rows);

        $panelAscii = new PanelComponent(
            $output,
            ['ascii', $tableAscii],
            $panelStyle
        );

        $group->addPanel($panelAscii);

        $tableStyleDouble = new TableStyle();
        $tableStyleDouble->setBorder('double')
            ->setWidth(50);

        $tableDouble = new TableComponent($output, $tableStyleDouble);
        $tableDouble->setHeaders($headers);
        $tableDouble->setRows($rows);

        $panelDouble = new PanelComponent(
            $output,
            ['double', $tableDouble],
            $panelStyle
        );

        $group->addPanel($panelDouble);

        $group->display();

        $output->writeln('');

        $group2 = new GroupComponent($output, $groupStyle);

        $tableStyleHeavy = new TableStyle();
        $tableStyleHeavy->setBorder('heavy')
            ->setWidth(50);

        $tableHeavy = new TableComponent($output, $tableStyleHeavy);
        $tableHeavy->setHeaders($headers);
        $tableHeavy->setRows($rows);

        $panelDouble = new PanelComponent(
            $output,
            ['heavy', $tableHeavy],
            $panelStyle
        );

        $group2->addPanel($panelDouble);

        $tableStyleHorizontals = new TableStyle();
        $tableStyleHorizontals->setBorder('horizontals')
            ->setWidth(50);

        $tableHorizontals = new TableComponent($output, $tableStyleHorizontals);
        $tableHorizontals->setHeaders($headers);
        $tableHorizontals->setRows($rows);

        $panelHorizontals = new PanelComponent(
            $output,
            ['horizontals', $tableHorizontals],
            $panelStyle
        );

        $group2->addPanel($panelHorizontals);

        $group2->display();

        $group3 = new GroupComponent($output, $groupStyle);

        $tableStyleRounded = new TableStyle();
        $tableStyleRounded->setBorder('rounded')
            ->setWidth(50);

        $tableRounded = new TableComponent($output, $tableStyleRounded);
        $tableRounded->setHeaders($headers);
        $tableRounded->setRows($rows);

        $panelRounded = new PanelComponent(
            $output,
            ['rounded', $tableRounded],
            $panelStyle
        );

        $group3->addPanel($panelRounded);

        $tableStyleRoundedCompact = new TableStyle();
        $tableStyleRoundedCompact->setBorder('rounded_compact')
            ->setWidth(50);

        $tableRoundedCompact = new TableComponent($output, $tableStyleRoundedCompact);
        $tableRoundedCompact->setHeaders($headers);
        $tableRoundedCompact->setRows($rows);

        $panelRoundedCompact = new PanelComponent(
            $output,
            ['rounded_compact', $tableRoundedCompact],
            $panelStyle
        );

        $group3->addPanel($panelRoundedCompact);

        $group3->display();

        $output->writeln('');

        return 0;
    }

    /**
     * @inheritDoc
     */
    public function description(): ?string
    {
        return 'Табличное отображение';
    }
}
