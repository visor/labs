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

    public function jsonSerialize(): array
    {
        return [
            'left' => $this->getLeft(),
            'right' => $this->getRight(),
            'weight' => $this->getWeight(),
            'size' => $this->size,
        ];
    }
}
