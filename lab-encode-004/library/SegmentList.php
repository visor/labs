<?php

declare(strict_types=1);

require_once __DIR__ . '/Segment.php';

class SegmentList
{
    public function __construct(
        private readonly array $segments,
        private readonly string $total,
    )
    {
    }

    public static function build(Stats $stats): self
    {
        $segments = [];

        $left = '0';
        foreach ($stats->getNormalized() as $letter => $count) {
            $segmentLeft = $left;
            $segmentRight = bcadd($left, (string)$count);

            $segments[$letter] = new Segment($letter, $segmentLeft, $segmentRight);

            $left = $segmentRight;
        }

        $last = array_pop($segments);
        $segments[$last->getLetter()] = new Segment(
            $last->getLetter(),
            $last->getLeft(),
            '1'
        );

        return new self($segments, (string)$stats->getTotal());
    }

    public function getTotal(): string
    {
        return $this->total;
    }

    public function get(string $letter): Segment
    {
        return $this->segments[$letter];
    }

    public function countLetters(): int
    {
        return count($this->segments);
    }

    public function getSegments(): array
    {
        return $this->segments;
    }
}
