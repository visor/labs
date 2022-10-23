<?php

declare(strict_types=1);

require_once __DIR__  . '/tree/NodeInterface.php';

class BinaryDataParser
{
    private int $cursor = 0;

    private int $length;

    private string $buffer;

    public function __construct(
        private readonly NodeInterface $tree,
        private readonly string $binaryData
    )
    {
        $this->length = strLen($this->binaryData);
    }

    public function parse(): string
    {
        $this->buffer = '';
        $this->cursor = $this->tree->getWeight();

        while ($this->cursor <= $this->length) {
            $this->parseBit($this->tree);
            ++$this->cursor;
        }

        return $this->buffer;
    }

    private function parseBit(NodeInterface $node, ?string $code = null): void
    {
        if ($node->isLeaf()) {
            $this->buffer .= $node->getLetter();
        } else {
            $this->parseNextBit($node, $code);
        }
    }

    private function parseNextBit(NodeInterface $node, ?string $code): void
    {
        if (false === $node instanceof RootNode) {
            ++$this->cursor;
        }
        if ($this->cursor >= $this->length) {
            return;
        }

        $newCode = $code . $this->binaryData[$this->cursor];
        if ($node->getLeft()->getCode() === $newCode) {
            $this->parseBit($node->getLeft(), $newCode);
        } elseif ($node->getRight()->getCode() === $newCode) {
            $this->parseBit($node->getRight(), $newCode);
        }
    }
}
