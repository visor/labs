<?php


require_once __DIR__  . '/library/TreePrinter.php';
require_once __DIR__  . '/library/ShFaDecoder.php';

$inputFile = __DIR__ . '/encoded/' . $argv[1];
$outputFile = __DIR__ . '/decoded/' . $argv[1];

$stats = (new Counter)->countFile($inputFile);
$tree = (new TreeBuilder())->build($stats);

echo $stats->getTotal(), PHP_EOL;

(new TreePrinter($tree))->print($stats);

$encoder = new ShFaEncoder($stats);
$encoder->encode($inputFile, $outputFile);

echo 'Done';
