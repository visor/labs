<?php

declare(strict_types=1);

require_once __DIR__  . '/Node.php';

class LetterNode extends Node
{
    public function __construct(
        int $weight,
        string $code,

        private readonly string $letter,
    )
    {
        parent::__construct($weight, null, null, $code);
    }

    public function getLetter(): ?string
    {
        return $this->letter;
    }

    public function isLeaf(): bool
    {
        return true;
    }

    public function searchByLetter(string $letter): ?NodeInterface
    {
        if ($this->getLetter() === $letter) {
            return $this;
        }

        return null;
    }

    public function searchByCode(string $code): ?NodeInterface
    {
        if ($this->getFullCode() === $code) {
            return $this;
        }

        return null;
    }

    public function jsonSerialize(): array
    {
        return [
            'code' => $this->getCode(),
            'letter' => base64_encode($this->getLetter()),
//            'letter' => $this->getLetter(),
        ];
    }
}
