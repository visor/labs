<?php

require_once __DIR__  . '/../lab-encode-002/library/Counter.php';
require_once __DIR__  . '/../lab-encode-002/library/TreeBuilder.php';
require_once __DIR__  . '/../lab-encode-002/library/TreePrinter.php';
require_once __DIR__  . '/../lab-encode-002/library/ShFaDecoder.php';

$inputFile = __DIR__ . '/encoded/' . $argv[1];
$outputFile = __DIR__ . '/decoded/' . $argv[1];

$decoder = new ShFaDecoder();
$decoder->decode($inputFile, $outputFile);

echo 'Done';
