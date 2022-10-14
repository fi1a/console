<?php

declare(strict_types=1);

namespace Fi1a\Console\IO\Style;

/**
 * ANSI стиль для консольного вывода
 */
class ANSIStyle extends AbstractStyle
{
    /**
     * @inheritDoc
     */
    public function apply(string $message): string
    {
        $set = [
            $this->getColor()->getColorCode(),
            $this->getBackground()->getBackgroundCode(),
        ];
        $options = $this->getOptions();
        if (count($options)) {
            foreach ($options as $option) {
                $set[] = $option->getCode();
            }
        }

        return sprintf("\x1b[%sm%s\x1b[0m", implode(';', $set), $message);
    }

    /**
     * @inheritDoc
     */
    public function getColor(): ColorInterface
    {
        return new ANSIColor($this->color);
    }

    /**
     * @inheritDoc
     */
    public function getBackground(): ColorInterface
    {
        return new ANSIColor($this->background);
    }

    /**
     * @inheritDoc
     */
    public function getOptions(): array
    {
        $options = [];
        foreach ($this->options as $option => $value) {
            $option = (string) $option;
            $option = mb_strtolower($option);
            if ($value) {
                switch ($option) {
                    case 'bold':
                        $options[] = new Bold();

                        break;
                    case 'underscore':
                        $options[] = new Underscore();

                        break;
                    case 'blink':
                        $options[] = new Blink();

                        break;
                    case 'reverse':
                        $options[] = new Reverse();

                        break;
                    case 'conceal':
                        $options[] = new Conceal();

                        break;
                    default:
                        throw new \InvalidArgumentException(sprintf('Unknown option "%s"', $option));
                }
            }
        }

        return $options;
    }
}
