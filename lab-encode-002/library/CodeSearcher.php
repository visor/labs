<?php

declare(strict_types=1);

class CodeSearcher
{
    private array $codes = [];

    public function __construct(
        private readonly NodeInterface $tree)
    {
    }

    public function getCode(string $letter): ?string
    {
        if (false === array_key_exists($letter, $this->codes)) {
            $code = $this->tree->searchByLetter($letter);
            if ($code instanceof NodeInterface) {
                return $this->codes[$letter] = $code->getFullCode();
            }

            throw new Exception('Letter not found: [' . $letter . ']');
        }

        return $this->codes[$letter];
    }
}
