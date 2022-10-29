<?php

declare(strict_types=1);

require_once __DIR__  . '/Node.php';

class RootNode extends Node
{
    private ?int $size;

    public function __construct(int $weight)
    {
        parent::__construct($weight);
    }

    public function setSize(?int $size): void
    {
        $this->size = $size;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function getLevel(): int
    {
        return 0;
    }

    public function jsonSerialize(): array
    {
        return [
            'l' => $this->getLeft(),
            'r' => $this->getRight(),
            'w' => $this->getWeight(),
            's' => $this->size,
        ];
    }
}
