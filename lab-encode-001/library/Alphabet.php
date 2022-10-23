<?php

class Alphabet
{
    private array $alphabet;

    public function __construct(
        private readonly string $letters
    )
    {
        $splittedLetters = preg_split('//u', $letters, -1, PREG_SPLIT_NO_EMPTY);
        $this->alphabet = array_flip($splittedLetters);
    }

    public static function createFromFile(string $fileName): Alphabet
    {
        return new Alphabet(trim(file_get_contents($fileName)));
    }

    public function hasLetter(string $letter): bool
    {
        return array_key_exists($letter, $this->alphabet);
    }

    public function getLetters(): string
    {
        return $this->letters;
    }

    public function shuffle(): Alphabet
    {
        $letters = array_keys($this->alphabet);
        shuffle($letters);
        return new Alphabet(implode('', $letters));
    }

    public function getIterator(): array
    {
        return array_keys($this->alphabet);
    }
}
