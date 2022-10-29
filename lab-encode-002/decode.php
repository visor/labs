<?php

require_once __DIR__  . '/library/Counter.php';
require_once __DIR__  . '/library/TreeBuilder.php';
require_once __DIR__  . '/library/ShFaDecoder.php';

$inputFile = __DIR__ . '/encoded/' . $argv[1];
$outputFile = __DIR__ . '/decoded/' . $argv[1];

$decoder = new ShFaDecoder();
$decoder->decode($inputFile, $outputFile);

echo 'Done';
