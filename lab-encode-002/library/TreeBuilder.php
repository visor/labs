<?php

declare(strict_types=1);

require_once __DIR__  . '/Stats.php';
require_once __DIR__  . '/StatsPair.php';
require_once __DIR__  . '/tree/Node.php';
require_once __DIR__  . '/tree/RootNode.php';
require_once __DIR__  . '/tree/LetterNode.php';

class TreeBuilder
{
    public function build(Stats $stats, ?NodeInterface $node = null): NodeInterface
    {
        $stats->sortByCount();
        if (null === $node) {
            $node = new RootNode($stats->getTotal());
        }

        if ($stats->canSplit()) {
            $this->buildPair($stats->split(), $node);
        }

        return $node;
    }

    private function buildPair(StatsPair $pair, NodeInterface $parent): void
    {
        $left = $pair->getFirst();
        $right = $pair->getSecond();

        $leftCode = $parent->getCode() . '0';
        $rightCode = $parent->getCode() . '1';
        if ($left->isLeaf()) {
            $parent->setLeft($this->buildLetterNode(
                $left->getTotal(),
                $leftCode,
                (string)$left->getLetters()[0]
            ));
        } else {
            $parent->setLeft(
                $this->buildNode($left->getTotal(), $leftCode)
            );
            $this->build($left, $parent->getLeft());
        }

        if ($right->isLeaf()) {
            $parent->setRight($this->buildLetterNode(
                $right->getTotal(),
                $rightCode,
                (string)$right->getLetters()[0]
            ));
        } else {
            $parent->setRight(
                $this->buildNode($right->getTotal(), $rightCode)
            );
            $this->build($right, $parent->getRight());
        }
    }

    private function buildNode(int $weight, string $code): Node
    {
        return new Node($weight, null, null, $code);
    }

    private function buildLetterNode(int $weight, string $code, string $letter): LetterNode
    {
        return new LetterNode($weight, $code, $letter);
    }
}
