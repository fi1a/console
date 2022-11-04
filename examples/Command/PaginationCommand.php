<?php

declare(strict_types=1);

namespace Fi1a\Console\Examples\Command;

use Fi1a\Console\AbstractCommand;
use Fi1a\Console\AppInterface;
use Fi1a\Console\Component\PaginationComponent\PaginationComponent;
use Fi1a\Console\Component\PaginationComponent\PaginationStyle;
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
 * Постраничная навигация
 */
class PaginationCommand extends AbstractCommand
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
            '<option=bold>Постраничная навигация</>',
            $panelStyleTitle
        );
        $panelTitle->display();
        $output->writeln('');

        $data = [
            ['Смартфон', '1000', '2', '2000'],
            ['Шкаф', '500', '1', '500'],
            ['Электробритва', '300', '5', '1500'],
            ['Станок', '200', '1', '200'],
            ['Диван', '1200', '1', '1200'],
            ['Кровать', '100', '2', '200'],
            ['Кресло', '300', '3', '900'],
            ['Шифанер', '150', '1', '150'],
            ['Стул', '50', '4', '200'],
            ['Стол', '100', '1', '100'],
        ];

        $tableStyle = new TableStyle();
        $table = new TableComponent($output, $tableStyle);
        $table->setHeaders(['Товар', 'Стоимость', 'Количество', 'Итоговая сумма']);
        $paginationStyle = new PaginationStyle();

        $pagination = new PaginationComponent($output, $stream, $paginationStyle);
        $pagination->setCount((int) ceil(count($data) / 3));
        $page = 1;
        do {
            $rows = array_slice($data, ($page - 1) * 3, 3);
            $table->setRows($rows);
            $table->display();
            $pagination->display();
            $page = $pagination->getCurrent();
        } while ($pagination->isValid());

        $output->writeln('');

        return 0;
    }

    /**
     * @inheritDoc
     */
    public function description(): ?string
    {
        return 'Постраничная навигация';
    }
}
