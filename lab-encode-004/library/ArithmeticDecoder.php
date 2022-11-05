<?php

declare(strict_types=1);

require_once __DIR__ . '/SegmentList.php';

class ArithmeticDecoder
{
    public function __construct(
        private readonly SegmentList $segments
    )
    {
    }

    public function decode(string $encoded, int $length): string
    {
        $result = '';

        $code = $encoded;
        for ($i = 0; $i < $length; ++$i) {
            foreach ($this->segments->getSegments() as $segment) {
                if (-1 === bccomp($code, $segment->getLeft())) {
                    continue;
                }
                if (-1 === bccomp($code, $segment->getRight())) {
                    $result .= $segment->getLetter();
                    echo $segment->getLetter();

                    $code = bcdiv(
                        bcsub($code, $segment->getLeft()),
                        bcsub($segment->getRight(), $segment->getLeft())
                    );
                    break;
                }
            }
        }
        echo PHP_EOL;

        return $result;
    }
}
