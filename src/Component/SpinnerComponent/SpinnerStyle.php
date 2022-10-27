<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\SpinnerComponent;

use InvalidArgumentException;

/**
 * Стиль
 */
class SpinnerStyle implements SpinnerStyleInterface
{
    /**
     * @var string
     */
    private $spinner = 'dots';

    /**
     * @var string
     */
    private $template = '{{if(title)}}{{title}} {{endif}}{{spinner}} ';

    /**
     * @inheritDoc
     */
    public function setSpinner(string $name)
    {
        if (!SpinnerRegistry::has($name)) {
            throw new InvalidArgumentException(sprintf('Неизвестный спиннер "%s"', $name));
        }

        $this->spinner = $name;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getSpinner(): string
    {
        return $this->spinner;
    }

    /**
     * @inheritDoc
     */
    public function setTemplate(string $template)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getTemplate(): string
    {
        return $this->template;
    }
}
