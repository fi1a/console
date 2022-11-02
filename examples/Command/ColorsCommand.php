<?php

declare(strict_types=1);

namespace Fi1a\Console\Examples\Command;

use Fi1a\Console\AbstractCommand;
use Fi1a\Console\AppInterface;
use Fi1a\Console\Definition\DefinitionInterface;
use Fi1a\Console\IO\ConsoleOutputInterface;
use Fi1a\Console\IO\Formatter;
use Fi1a\Console\IO\InputArgumentsInterface;
use Fi1a\Console\IO\InputInterface;
use Fi1a\Console\IO\Style\ANSIStyle;
use Fi1a\Console\IO\Style\ColorInterface;
use Fi1a\Console\IO\Style\ExtendedStyle;
use Fi1a\Console\IO\Style\TrueColorStyle;

/**
 * Цвета
 */
class ColorsCommand extends AbstractCommand
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
        $output->writeln(['', '', '<option=bold>Цветовые схемы (палитра цветов консоли)</>']);

        $output->writeln(['', '', '<color=red>ANSI (4-bit color)</>', '']);
        $output->setFormatter(new Formatter(ANSIStyle::class));
        $ansiColors = [
            ColorInterface::BLACK, ColorInterface::RED, ColorInterface::GREEN, ColorInterface::YELLOW,
            ColorInterface::BLUE, ColorInterface::MAGENTA, ColorInterface::CYAN, ColorInterface::GRAY,
            ColorInterface::DARK_GRAY, ColorInterface::LIGHT_RED, ColorInterface::LIGHT_GREEN,
            ColorInterface::LIGHT_YELLOW, ColorInterface::LIGHT_BLUE, ColorInterface::LIGHT_MAGENTA,
            ColorInterface::LIGHT_CYAN, ColorInterface::WHITE,
        ];
        for ($color = 0; $color < count($ansiColors); $color++) {
            $output->write('  ', [], new ANSIStyle(null, $ansiColors[$color]));
        }
        $output->writeln('');

        $output->writeln(['', '', '<color=red>Extended (8-bit color)</>', '']);
        $output->setFormatter(new Formatter(ExtendedStyle::class));
        for ($green = 0; $green < 6; $green++) {
            for ($red = 0; $red < 6; $red++) {
                for ($blue = 0; $blue < 6; $blue++) {
                    $output->write(
                        '  ',
                        [],
                        new ExtendedStyle(null, (string) (16 + ($red * 36) + ($green * 6) + $blue))
                    );
                }
                $output->write(' ');
            }
            $output->writeln();
        }

        $output->writeln(['', '', '<color=red>TrueColor (16.7 million)</>', '']);
        $output->setFormatter(new Formatter(TrueColorStyle::class));

        for ($red = 0; $red <= 250; $red += 50) {
            for ($green = 0; $green <= 250; $green += 50) {
                for ($blue = 0; $blue <= 250; $blue += 50) {
                    $output->write(
                        '  ',
                        [],
                        new TrueColorStyle(
                            null,
                            sprintf('#%02x%02x%02x', $red, $green, $blue)
                        )
                    );
                }
                $output->write(' ');
            }
            $output->writeln('');
        }

        $output->writeln(['', '']);

        return 0;
    }

    /**
     * @inheritDoc
     */
    public function description(): ?string
    {
        return 'Цветовые схемы (палитра цветов консоли) ANSI (4-bit color), '
            . 'Extended (8-bit color), TrueColor (16.7 million)';
    }
}
