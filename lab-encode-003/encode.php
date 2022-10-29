<?php

require_once __DIR__  . '/../lab-encode-002/library/Counter.php';
require_once __DIR__  . '/library/HaffmanTreeBuilder.php';
require_once __DIR__  . '/../lab-encode-002/library/TreeEncoder.php';

$inputFile = __DIR__ . '/../lab-encode-texts/' . $argv[1];
$outputFile = __DIR__ . '/encoded/' . $argv[2];

$stats = (new Counter)->countFile($inputFile);
$tree = (new HaffmanTreeBuilder())->build($stats);

echo $tree;

$encoder = new TreeEncoder($tree);
$encoder->encode($inputFile, $outputFile);

echo 'Done';
