<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\TreeComponent;

use Fi1a\Console\Component\ComponentInterface;

/**
 * Узел дерева
 */
interface TreeNodeInterface
{
    /**
     * Добавить узел
     */
    public function addNode(string $title, ?TreeStyleInterface $style = null): TreeNodeInterface;

    /**
     * Установить узлы
     *
     * @param TreeNodeInterface[] $nodes
     *
     * @return $this
     */
    public function setNodes(array $nodes);

    /**
     * Возвращает узлы
     *
     * @return TreeNodeInterface[]
     */
    public function getNodes(): array;

    /**
     * Установить стиль
     *
     * @return $this
     */
    public function setStyle(?TreeStyleInterface $style);

    /**
     * Вернуть стиль
     */
    public function getStyle(): ?TreeStyleInterface;

    /**
     * Установить заголовок
     *
     * @return $this
     */
    public function setTitle(string $title);

    /**
     * Вернуть заголовок
     */
    public function getTitle(): string;

    /**
     * Установить текст
     *
     * @param string|ComponentInterface|string[]|ComponentInterface[] $text
     *
     * @return $this
     */
    public function setText($text);

    /**
     * Вернуть текст
     *
     * @return string[]|ComponentInterface[]
     */
    public function getText(): array;
}
