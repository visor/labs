<?php

declare(strict_types=1);

require_once __DIR__  . '/../../lab-encode-002/library/Stats.php';
require_once __DIR__  . '/../../lab-encode-002/library/StatsPair.php';
require_once __DIR__  . '/../../lab-encode-002/library/TreeBuilder.php';
require_once __DIR__  . '/../../lab-encode-002/library/tree/Node.php';
require_once __DIR__  . '/../../lab-encode-002/library/tree/RootNode.php';
require_once __DIR__  . '/../../lab-encode-002/library/tree/LetterNode.php';
require_once __DIR__  . '/HaffmanPool.php';

class HaffmanTreeBuilder extends TreeBuilder
{
    public function build(Stats $stats, ?NodeInterface $node = null): NodeInterface
    {
        $pool = HaffmanPool::createFromStats($stats);

        while ($pool->count() > 1) {
            $pool->joinNodePair();
        }

        return $pool->first();
    }
}
