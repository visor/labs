<?php

declare(strict_types=1);

require_once __DIR__ . '/library/HammingCode.php';

$messageLength = (int)$argv[1];
$dataLength    = (int)$argv[2];
$data          = $argv[3];

$hamming = new HammingCode($messageLength, $dataLength, false);
$data    = BitArray::createFromString($data);

echo '  ', $data, PHP_EOL;

$result  = $hamming->encode($data);
echo '==', $result, '  ', $hamming->decode($result), PHP_EOL, PHP_EOL;

for ($i = 0; $i < $messageLength; ++$i) {
    $test = $result->copy();
    $test->invertBit($i);

    echo '==', $result, PHP_EOL;
    echo '--', $test, '  ', $hamming->decode($test), PHP_EOL, PHP_EOL;
}
