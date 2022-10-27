<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\ProgressbarComponent;

/**
 * Стиль
 */
interface ProgressbarStyleInterface
{
    /**
     * Установить шаблон
     *
     * @return $this
     */
    public function setTemplate(string $template);

    /**
     * Вернуть шаблон
     */
    public function getTemplate(): string;

    /**
     * Установить шаблон п имени из коллекции
     *
     * @return $this
     */
    public function setTemplateByName(string $name);

    /**
     * Установить ширину
     *
     * @return $this
     */
    public function setWidth(int $width);

    /**
     * Вернуть ширину
     */
    public function getWidth(): int;

    /**
     * Устанавливает символ прогрессбара
     *
     * @return $this
     */
    public function setCharacter(string $character);

    /**
     * Возвращает символ прогрессбара
     */
    public function getCharacter(): string;

    /**
     * Устанавливает символ прогрессбара (пустое)
     *
     * @return $this
     */
    public function setEmptyCharacter(string $character);

    /**
     * Возвращает символ прогрессбара (пустое)
     */
    public function getEmptyCharacter(): string;

    /**
     * Устанавливает символ прогрессбара (текущее)
     *
     * @return $this
     */
    public function setProgressCharacter(string $character);

    /**
     * Возвращает символ прогрессбара (текущее)
     */
    public function getProgressCharacter(): string;
}
