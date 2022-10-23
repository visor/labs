<?php

require_once __DIR__ . '/library/LetterCounter.php';

$inputFile = __DIR__ . '/texts/source/' . $argv[1];
$targetFile = $inputFile . '.json';

$alphabet = Alphabet::createFromFile(__DIR__ . '/texts/alphabet.txt');
$counter = new LetterCounter($alphabet);
$counter->countFile($inputFile);

echo var_export($counter->toArray(), true), PHP_EOL;
file_put_contents($targetFile, json_encode($counter->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
