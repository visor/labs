<?php

declare(strict_types=1);

require_once __DIR__ . '/library/HammingCode.php';

$messageLength = (int)$argv[1];
$dataLength    = (int)$argv[2];
$data          = $argv[3];

$hamming = new HammingCode($messageLength, $dataLength, false);
$data    = BitArray::createFromString($data);

echo '  ', $data, PHP_EOL;

$result  = $hamming->decode($data);
echo '  ', $result, PHP_EOL;
