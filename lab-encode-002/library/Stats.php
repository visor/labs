<?php

declare(strict_types=1);

require_once __DIR__  . '/StatsPair.php';

class Stats
{
    private array $letters = [];

    private int $total = 0;

    private ?StatsPair $split = null;

    public function addLetter(string $letter): void
    {
        if (isset($this->letters[$letter])) {
            ++$this->letters[$letter];
        } else {
            $this->letters[$letter] = 1;
        }

        ++$this->total;
    }

    public function sortByCount(): void
    {
        arsort($this->letters);
    }

    public function split(): StatsPair
    {
        if (null == $this->split) {
            $this->sortByCount();
            $half = round($this->total / 2);

            $first  = new Stats();
            $second = new Stats();

            $letters = array_keys($this->letters);
            while ($first->getTotal() < $half && count($letters) > 0) {
                $letter = array_shift($letters);
                $first->copyLetter($letter, $this->letters[$letter]);
            }

            foreach ($letters as $letter) {
                $second->copyLetter($letter, $this->letters[$letter]);
            }

            $this->split = new StatsPair($first, $second);
        }

        return $this->split;
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    public function countLetters(): int
    {
        return count($this->letters);
    }

    public function getLetters(): array
    {
        return array_keys($this->letters);
    }

    public function getLetterCount(string $letter): ?int
    {
        return $this->letters[$letter] ?? 0;
    }

    public function canSplit(): bool
    {
        return $this->countLetters() > 1;
    }

    public function isLeaf(): bool
    {
        return 1 === $this->countLetters();
    }

    public function __toString(): string
    {
        $result = '';

        foreach ($this->letters as $letter => $count) {
            $toPrint = $letter;
            if ("\t" === $toPrint) {
                $toPrint = '\t';
            }
            if ("\r" === $toPrint) {
                $toPrint = '\r';
            }
            if ("\n" === $toPrint) {
                $toPrint = '\n';
            }
            $result .= sprintf("%s\t%10d\n", $toPrint, $count);
        }

        $result .= sprintf("Total\t%10d\n", $this->total);

        return $result;
    }

    private function copyLetter($letter, $count): void
    {
        $this->letters[$letter] = $count;
        $this->total += $count;
    }

}
