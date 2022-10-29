<?php

declare(strict_types=1);

class HaffmanPool
{
    /**
     * @var array|\NodeInterface[]
     */
    private array $nodes = [];

    public static function createFromStats(Stats $stats): HaffmanPool
    {
        $stats->sortByCount(); // Статистика отсортирована по возрастанию (в начале самые популярные).
        $result = new self();

        foreach ($stats->getLetters() as $letter) {
            $result->pushNode(
                $result->createLetterNode(
                    $stats->getLetterCount($letter),
                    $letter
                )
            );
        }

        return $result;
    }

    public function first(): NodeInterface
    {
        return $this->nodes[0];
    }

    public function count(): int
    {
        return count($this->nodes);
    }

    public function pushNode(NodeInterface $node)
    {
        $this->nodes[] = $node;
    }

    /**
     * Метод построения дерева по алгоритму Хаффмана
     */
    public function joinNodePair(): void
    {
        if (0 === $this->count()) { // Если дерево оказалось пустым, что-то пошло не так.
            throw new \RuntimeException('Error');
        }
        if (1 === $this->count()) { // Если узел только один — всё сделали.
            return;
        }

        $left = array_pop($this->nodes);  // Выбираем два узла
        $right = array_pop($this->nodes); // с низкой статистикой
        if ($left->getWeight() < $right->getWeight()) { // Слева будут самые "тяжёлые"
            $temp = $left;
            $left = $right;
            $right = $temp;
        }

        $left->setCode(0);
        $right->setCode(1);

        if ($this->count() > 0) { // Если ещё есть узлы, то строим ветку
            $pair = new Node(
                $left->getWeight() + $right->getWeight(), // суммарный вес пары
                $left,
                $right,
            );

            // ищем куда вставить новый узел
            $index = $this->count() - 1;
            while ($index > 0 && $pair->getWeight() > $this->nodes[$index]->getWeight()) {
                --$index;
            }

            array_splice($this->nodes, $index, 0, [$pair]); // вставляем новый узел
            return;
        }

        $root = new RootNode($left->getWeight() + $right->getWeight()); // это последний узел — корень дерева
        $root->setLeft($left);
        $root->setRight($right);
        $this->pushNode($root);
    }

    protected function createLetterNode(int $weight, string $letter): LetterNode
    {
        return new LetterNode($weight, null, $letter);
    }
}
