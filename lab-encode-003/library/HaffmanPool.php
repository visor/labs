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

    public function joinNodePair(): void
    {
        if (0 === $this->count()) {
            throw new \RuntimeException('Error');
        }
        if (1 === $this->count()) {
            return;
        }

        $left = array_pop($this->nodes);
        $right = array_pop($this->nodes);
        if ($left->getWeight() < $right->getWeight()) {
            $temp = $left;
            $left = $right;
            $right = $temp;
        }

        $left->setCode('0');
        $right->setCode('1');

        if ($this->count() > 0) {
            $pair = new Node(
                $left->getWeight() + $right->getWeight(),
                $left,
                $right,
            );

            $index = $this->count() - 1;
            while ($index > 0 && $pair->getWeight() > $this->nodes[$index]->getWeight()) {
                --$index;
            }

            array_splice($this->nodes, $index, 0, [$pair]);
            return;
        }

        $root = new RootNode($left->getWeight() + $right->getWeight());
        $root->setLeft($left);
        $root->setRight($right);
        $this->pushNode($root);
    }

    protected function createLetterNode(int $weight, string $letter): LetterNode
    {
        return new LetterNode($weight, '', $letter);
    }
}
