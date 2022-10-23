<?php

require_once __DIR__ . '/library/Alphabet.php';

$inputFile = __DIR__ . '/texts/original/' . $argv[1];
$outputFile = __DIR__ . '/texts/source/' . $argv[1];
$alphabet = Alphabet::createFromFile(__DIR__ . '/texts/alphabet.txt');

$fin = fopen($inputFile, 'r');
$fout = fopen($outputFile, 'w+');

while (!feof($fin)) {
    $line = fgets($fin);
    $line = strip_tags($line);
    $line = trim($line);
    $line = mb_strtoupper($line, 'UTF-8');
    $targetLine = '';

    foreach (preg_split('//u', $line, -1, PREG_SPLIT_NO_EMPTY) as $letter) {
        if ($alphabet->hasLetter($letter)) {
            $targetLine .= $letter;
        }
    }

    $targetLine = preg_replace('/\s+/', ' ', $targetLine);
    $targetLine = trim($targetLine);
    if (empty($targetLine)) {
        continue;
    }

    fwrite($fout, $targetLine . PHP_EOL);
    echo '.';
}

fclose($fin);
fclose($fout);
echo PHP_EOL;
