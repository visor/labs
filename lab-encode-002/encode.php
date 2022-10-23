<?php

require_once __DIR__  . '/library/Counter.php';
require_once __DIR__  . '/library/TreeBuilder.php';
require_once __DIR__  . '/library/TreePrinter.php';
require_once __DIR__  . '/library/ShFaEncoder.php';

$inputFile = __DIR__ . '/../lab-encode-texts/' . $argv[1];
$outputFile = __DIR__ . '/encoded/' . $argv[2];

$stats = (new Counter)->countFile($inputFile);
$tree = (new TreeBuilder())->build($stats);

echo $stats->getTotal(), PHP_EOL;

(new TreePrinter($tree))->print($stats);

$encoder = new ShFaEncoder($stats);
$encoder->encode($inputFile, $outputFile);

echo 'Done';
