<?php

require_once __DIR__ . '/library/Decoder.php';

$inputFile = __DIR__ . '/texts/encoded/' . $argv[1];
$outputFile = __DIR__ . '/texts/decoded/' . $argv[1];
$frequencyFile = __DIR__ . '/texts/source/' . $argv[2];
$outputFileKey = $outputFile . '.key';

$alphabet = Alphabet::createFromFile(__DIR__ . '/texts/alphabet.txt');
$frequency = json_decode(file_get_contents($frequencyFile), true);
$decoder = new Decoder($alphabet, $frequency);
$encoded = $decoder->decodeFile($inputFile);

file_put_contents($outputFile, $encoded);
