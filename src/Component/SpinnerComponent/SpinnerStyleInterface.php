<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\SpinnerComponent;

/**
 * Стиль
 */
interface SpinnerStyleInterface
{
    /**
     * Установить спиннер
     *
     * @return $this
     */
    public function setSpinner(string $name);

    /**
     * Вернуть спиннер
     */
    public function getSpinner(): string;

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
}
