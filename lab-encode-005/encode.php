<?php

declare(strict_types=1);

require_once __DIR__ . '/library/LzEncoder.php';

$inputFile = __DIR__ . '/../lab-encode-texts/' . $argv[1];
$outputFile = __DIR__ . '/encoded/' . $argv[2];

//(new LzEncoder(4096, 256))->encode($inputFile, $outputFile);
(new LzEncoder(8, 5))->encode($inputFile, $outputFile);
