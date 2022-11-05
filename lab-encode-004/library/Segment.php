<?php

declare(strict_types=1);

class Segment
{
    public function __construct(
        private readonly string $letter,
        private readonly string $left,
        private readonly string $right,
    )
    {
    }

    public function getLetter(): string
    {
        return $this->letter;
    }

    public function getLeft(): string
    {
        return $this->left;
    }

    public function getRight(): string
    {
        return $this->right;
    }
}
