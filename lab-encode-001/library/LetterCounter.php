<?php

require_once __DIR__ . '/Alphabet.php';

class LetterCounter
{
    private int $total = 0;

    private array $letters = [];

    private bool $prepared = false;

    private array $indexes = [];

    public function __construct(
        private readonly Alphabet $alphabet,
    )
    {
    }

    public function countFile(string $fileName): void
    {
        $fin = fopen($fileName, 'r');
        while (!feof($fin)) {
            $line = fgets($fin);

            foreach (preg_split('//u', $line, -1, PREG_SPLIT_NO_EMPTY) as $letter) {
                $this->countLetter($letter);
            }
        }

        fclose($fin);
    }

    public function countLetter(string $letter): void
    {
        if (!$this->alphabet->hasLetter($letter)) {
            return;
        }

        if (array_key_exists($letter, $this->letters)) {
            ++$this->letters[$letter];
        } else {
            $this->letters[$letter] = 1;
        }
        ++$this->total;
    }

    public function getFrequency(string $letter): float
    {
        return $this->getCount($letter) / $this->total;
    }

    public function getIndex(string $letter): int
    {
        $this->prepare();

        return $this->indexes[$letter] ?? -1;
    }

    public function prepare(): void
    {
        if ($this->prepared) {
            return;
        }

        asort($this->letters, SORT_NUMERIC);
        $index = 0;
        foreach ($this->letters as $letter => $count) {
            $this->indexes[$letter] = $index;
            ++$index;
        }
    }

    public function toArray(): array
    {
        $result = [];
        $this->prepare();
        foreach ($this->alphabet->getIterator() as $letter) {
            $result[$letter] = [
                'frequency' => $this->getFrequency($letter),
                'index' => $this->getIndex($letter),
            ];
        }

        uasort($result, function ($a, $b) {
            return ($a['index'] < $b['index']) ? 1 : -1;
        });

        return $result;
    }

    protected function getCount(string $letter): int
    {
        return $this->letters[$letter] ?? 0;
    }
}
