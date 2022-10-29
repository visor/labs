<?php

declare(strict_types=1);

require_once __DIR__  . '/NodeInterface.php';

class Node implements NodeInterface
{
    private ?NodeInterface $parent = null;

    private ?string $fullCode = null;

    public function __construct(
        private ?int $weight,
        private ?NodeInterface $left = null,
        private ?NodeInterface $right = null,
        private ?int $code = null,
    )
    {
        $this->left?->setParent($this);
        $this->right?->setParent($this);
    }

    public function getParent(): ?NodeInterface
    {
        return $this->parent;
    }

    public function setParent(?NodeInterface $node = null): void
    {
        $this->parent = $node;
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

    public function getCode(): ?int
    {
        return $this->code;
    }

    public function getFullCode(): ?string
    {
        if (null === $this->fullCode) {
            $this->fullCode = $this->getParent()?->getFullCode() . $this->code;
        }

        return $this->fullCode;
    }

    public function setCode(?int $code): void
    {
        $this->code = $code;
    }

    public function setLeft(?NodeInterface $left): void
    {
        $this->left = $left;
        $left->setParent($this);
    }

    public function getLeft(): ?NodeInterface
    {
        return $this->left;
    }

    public function setRight(?NodeInterface $right): void
    {
        $this->right = $right;
        $right->setParent($this);
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
            'l' => $this->left,
            'r' => $this->right,
            'c' => $this->code,
        ];
    }
}
