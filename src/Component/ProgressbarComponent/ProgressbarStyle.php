<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\ProgressbarComponent;

use InvalidArgumentException;

/**
 * Стиль
 */
class ProgressbarStyle implements ProgressbarStyleInterface
{
    /**
     * @var string
     */
    private $template = '{{current}}/{{max}} [{{bar}}] {{percent|sprintf("3s")}}%{{if(title)}} {{title}}{{endif}}';

    /**
     * @var int
     */
    private $width = 28;

    /**
     * @var string
     */
    private $character = '=';

    /**
     * @var string
     */
    private $emptyCharacter = '-';

    /**
     * @var string
     */
    private $progressCharacter = '>';

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

    /**
     * @inheritDoc
     */
    public function setTemplateByName(string $name)
    {
        $this->template = ProgressbarTemplateRegistry::get($name);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setWidth(int $width)
    {
        if ($width <= 0) {
            throw new InvalidArgumentException('Ширина не может быть меньше или равной нулю');
        }
        $this->width = $width;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * @inheritDoc
     */
    public function setCharacter(string $character)
    {
        $this->character = $character;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getCharacter(): string
    {
        return $this->character;
    }

    /**
     * @inheritDoc
     */
    public function setEmptyCharacter(string $character)
    {
        $this->emptyCharacter = $character;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getEmptyCharacter(): string
    {
        return $this->emptyCharacter;
    }

    /**
     * @inheritDoc
     */
    public function setProgressCharacter(string $character)
    {
        $this->progressCharacter = $character;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getProgressCharacter(): string
    {
        return $this->progressCharacter;
    }
}
