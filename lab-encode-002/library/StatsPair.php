<?php

declare(strict_types=1);

class StatsPair
{
    public function __construct(
        private readonly Stats $first,
        private readonly Stats $second,
    )
    {
    }

    public function getFirst(): Stats
    {
        return $this->first;
    }

    public function getSecond(): Stats
    {
        return $this->second;
    }

    public function __toString(): string
    {
        return
            sprintf("Half\t%10d\n", round(($this->first->getTotal() + $this->second->getTotal()) / 2))
            . 'First:' . PHP_EOL . $this->first . PHP_EOL
            . 'Second:' . PHP_EOL . $this->second . PHP_EOL
        ;
    }
}
