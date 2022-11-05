<?php

declare(strict_types=1);

require_once __DIR__  . '/../lab-encode-002/library/Counter.php';
require_once __DIR__  . '/library/SegmentList.php';
require_once __DIR__  . '/library/ArithmeticEncoder.php';
require_once __DIR__  . '/library/ArithmeticDecoder.php';

bcscale(1000);

$inputFile = __DIR__ . '/../lab-encode-texts/' . $argv[1];
$outputFile = __DIR__ . '/encoded/' . $argv[2];

$stats = (new Counter)->countFile($inputFile);
$stats->sortByCount();
echo var_export($stats, true), PHP_EOL;


$segments = SegmentList::build($stats);
echo var_export($segments, true), PHP_EOL;

$encoded = (new ArithmeticEncoder($segments))->encode($inputFile, $outputFile);

echo var_export($encoded), PHP_EOL;

$decoded = (new ArithmeticDecoder($segments))->decode($encoded, $stats->getTotal());

echo $decoded, PHP_EOL;
