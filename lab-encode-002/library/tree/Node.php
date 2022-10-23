<?php

declare(strict_types=1);

require_once __DIR__  . '/NodeInterface.php';

class Node implements NodeInterface
{
    public function __construct(
        private ?int $weight,
        private ?NodeInterface $left = null,
        private ?NodeInterface $right = null,
        private ?string $code = null,
    )
    {
    }

    public function getLetter(): ?string
    {
        return null;
    }

    public function setWeight(?int $weight): void
    {
        $this->weight = $weight;
    }

    public function getWeight(): int
    {
        return $this->weight;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setLeft(?NodeInterface $left): void
    {
        $this->left = $left;
    }

    public function getLeft(): ?NodeInterface
    {
        return $this->left;
    }

    public function setRight(?NodeInterface $right): void
    {
        $this->right = $right;
    }

    public function getRight(): ?NodeInterface
    {
        return $this->right;
    }

    public function isLeaf(): bool
    {
        return false;
    }

    public function searchByLetter(string $letter): ?NodeInterface
    {
        if ($this->left instanceof NodeInterface) {
            $result = $this->left->searchByLetter($letter);
            
            if ($result instanceof NodeInterface) {
                return $result;
            }
        }

        if ($this->right instanceof NodeInterface) {
            $result = $this->right->searchByLetter($letter);
            
            if ($result instanceof NodeInterface) {
                return $result;
            }
        }

        return null;
    }

    public function searchByCode(string $code): ?NodeInterface
    {
        if ($this->left instanceof NodeInterface) {
            $result = $this->left->searchByCode($code);

            if ($result instanceof NodeInterface) {
                return $result;
            }
        }

        if ($this->right instanceof NodeInterface) {
            $result = $this->right->searchByCode($code);

            if ($result instanceof NodeInterface) {
                return $result;
            }
        }

        return null;
    }

    public function jsonSerialize(): array
    {
        return [
            'left' => $this->left,
            'right' => $this->right,
            'code' => $this->code,
        ];
    }
}
