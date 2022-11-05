<?php

declare(strict_types=1);

require_once __DIR__ . '/SegmentList.php';

class ArithmeticEncoder
{
    public function __construct(
        private readonly SegmentList $segments
    )
    {
    }

    public function encode(string $sourceFileName, string $targetFileName): string
    {
        $letters = $this->getLettersFromFile($sourceFileName);

        $left = '0';
        $right = '1';
        foreach ($letters as $letter) {
            $letterSegment = $this->segments->get($letter);
            $range = bcsub($right, $left);
            $segmentLeft = bcmul($range, $letterSegment->getLeft());
            $segmentRight = bcmul($range, $letterSegment->getRight());

            $newLeft = bcadd($left, $segmentLeft);
            $newRight = bcadd($left, $segmentRight);

            $left = $newLeft;
            $right = $newRight;
        }

        return bcdiv(bcadd($right, $left), '2');
    }

    protected function getLettersFromFile(string $sourceFileName): array
    {
        $result = [];

        $fin = fopen($sourceFileName, 'r');
        while (!feof($fin)) {
            $line = fgets($fin);
            if (false === $line) {
                continue;
            }

            foreach (Helper::getUtfLetters($line) as $letter) {
                $result[] = $letter;
            }
        }
        fclose($fin);

        return $result;
    }

    protected function writeHeader($resource): void
    {
        //
    }

}
