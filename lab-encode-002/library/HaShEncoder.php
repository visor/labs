<?php

declare(strict_types=1);

require_once __DIR__  . '/Stats.php';
require_once __DIR__  . '/TreeBuilder.php';

class HaShEncoder
{
    private readonly NodeInterface $tree;

    private array $codes = [];

    public function __construct(
        private readonly Stats $stats,
    )
    {
        $this->tree = (new TreeBuilder())->build($this->stats);
    }

    public function getLetterBinCode(string $letter): int
    {
        return bindec($this->getLetterCode($letter));
    }

    public function getLetterCode(string $letter): ?string
    {
        if (false === array_key_exists($letter, $this->codes)) {
            $code = $this->tree->searchByLetter($letter);
            if ($code instanceof NodeInterface) {
                $this->codes[$letter] = $code->getCode();
            } else {
                $this->codes[$letter] = '-------';
            }

        }

        return $this->codes[$letter];
    }
}
