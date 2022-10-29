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

    public function restoreFromJson(\stdClass $json, ?NodeInterface $node = null): ?NodeInterface
    {
        if (null == $node) {
            $node = new RootNode($json->w ?? 0);
            $node->setSize($json->s ?? -1);
        }

        if (isset($json->l) && isset($json->r)) {
            $this->restoreNode($json->l, $json->r, $node);
        }

        return $node;
    }

    protected function restoreNode(\stdClass $left, \stdClass $right, NodeInterface $parent): void
    {
        if (isset($left->_)) {
            $parent->setLeft($this->restoreLetterNode($left->c, $left->_));
        } else {
            $leftNode = $this->buildNode(0, $left->c);

            $parent->setLeft($leftNode);
            $this->restoreFromJson($left, $leftNode);
        }

        if (isset($right->_)) {
            $parent->setRight($this->restoreLetterNode($right->c, $right->_));
        } else {
            $rightNode = $this->buildNode(0, $right->c);

            $parent->setRight($rightNode);
            $this->restoreFromJson($right, $rightNode);
        }
    }

    protected function buildPair(StatsPair $pair, NodeInterface $parent): void
    {
        $left = $pair->getFirst();
        $right = $pair->getSecond();

        $leftCode = 0;
        $rightCode = 1;

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

    protected function buildNode(int $weight, int $code): Node
    {
        return new Node($weight, null, null, $code);
    }

    protected function buildLetterNode(int $weight, int $code, string $letter): LetterNode
    {
        return new LetterNode($weight, $code, $letter);
    }

    protected function restoreLetterNode(int $code, $letter): LetterNode
    {
        return new LetterNode(0, $code, base64_decode($letter));
    }
}
