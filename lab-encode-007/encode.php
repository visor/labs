<?php

declare(strict_types=1);

require_once __DIR__ . '/library/RepeatEncoder.php';

$word = $argv[1];
$encoder = new RepeatEncoder(3);

$encoded = $encoder->encode($word);
$decoded = $encoder->decode($encoded);

echo 'word:    ', $word, PHP_EOL;
echo 'encoded: ', $encoded, PHP_EOL;
echo 'decoded: ', $decoded, PHP_EOL;


$wrong = $encoder->messUp($encoded);
$wrongDecoded = $encoder->decode($wrong);

echo 'mess up: ', $wrong, PHP_EOL;
echo 'decoded: ', $wrongDecoded, PHP_EOL;
