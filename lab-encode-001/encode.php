<?php

require_once __DIR__ . '/library/Encoder.php';

$inputFile = __DIR__ . '/texts/source/' . $argv[1];
$outputFile = __DIR__ . '/texts/encoded/' . $argv[1];
$outputFileKey = $outputFile . '.key';

$alphabet = Alphabet::createFromFile(__DIR__ . '/texts/alphabet.txt');
$key = $alphabet->shuffle();

$encoder = new Encoder($alphabet, $key);
$encoded = $encoder->encodeFile($inputFile);

file_put_contents($outputFile, $encoded);
file_put_contents($outputFileKey, $alphabet->getLetters() . PHP_EOL . $key->getLetters() . PHP_EOL);
