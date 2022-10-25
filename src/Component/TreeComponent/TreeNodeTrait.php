<?php

declare(strict_types=1);

namespace Fi1a\Console\Component\TreeComponent;

use Fi1a\Console\Component\ComponentInterface;

/**
 * Методы узла
 */
trait TreeNodeTrait
{
    /**
     * @var TreeNodeInterface[]
     */
    private $nodes = [];

    /**
     * @var TreeStyleInterface|null
     */
    private $style;

    /**
     * @var string
     */
    private $title = '';

    /**
     * @var string[]|ComponentInterface[]
     */
    private $text = [];

    /**
     * Добавить узел
     */
    public function addNode(string $title, ?TreeStyleInterface $style = null): TreeNodeInterface
    {
        $node = new TreeNode($title, [], $style);
        $this->nodes[] = $node;

        return $node;
    }

    /**
     * Установить узлы
     *
     * @param TreeNodeInterface[] $nodes
     *
     * @return $this
     */
    public function setNodes(array $nodes)
    {
        $this->nodes = $nodes;

        return $this;
    }

    /**
     * Возвращает узлы
     *
     * @return TreeNodeInterface[]
     */
    public function getNodes(): array
    {
        return $this->nodes;
    }

    /**
     * Установить стиль
     *
     * @return $this
     */
    public function setStyle(?TreeStyleInterface $style)
    {
        $this->style = $style;

        return $this;
    }

    /**
     * Вернуть стиль
     */
    public function getStyle(): ?TreeStyleInterface
    {
        return $this->style;
    }

    /**
     * Установить заголовок
     *
     * @return $this
     */
    public function setTitle(string $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Вернуть заголовок
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Установить текст
     *
     * @param string|ComponentInterface|string[]|ComponentInterface[] $text
     *
     * @return $this
     */
    public function setText($text)
    {
        if (!is_array($text)) {
            $text = [$text];
        }

        $this->text = $text;

        return $this;
    }

    /**
     * Вернуть текст
     *
     * @return string[]|ComponentInterface[]
     */
    public function getText(): array
    {
        return $this->text;
    }
}
