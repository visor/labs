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

        $result = null;
        $left = '0';
        $right = '1';
        foreach ($letters as $letter) {
            $range = bcsub($right, $left);
            $segmentLeft = bcmul($range, $this->segments->get($letter)->getLeft());
            $segmentRight = bcmul($range, $this->segments->get($letter)->getRight());

            $newLeft = bcadd($left, $segmentLeft);
            $newRight = bcadd($left, $segmentRight);

            $left = $newLeft;
            $right = $newRight;
        }

        return $left;
//
//        return [
//            'encoded' => $result,
//            'length' => $this->segments->getTotal(),
//        ];
//
//        echo $result, PHP_EOL, strlen($result), PHP_EOL;
//        $this->writeToFile($targetFileName);
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
