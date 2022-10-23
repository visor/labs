<?php

require_once __DIR__  . '/library/Counter.php';
require_once __DIR__  . '/library/TreeBuilder.php';
require_once __DIR__  . '/library/HaShEncoder.php';

$inputFile = __DIR__ . '/../lab-encode-texts/' . $argv[1];
$stats = (new Counter)->countFile($inputFile);
$tree = (new TreeBuilder())->build($stats);
$encoder = new HaShEncoder($stats);

$moreThan8Bit = false;
$moreThan16Bit = false;
foreach ($stats->getLetters() as $letter) {
    $toPrint = $letter;
    if ("\t" === $toPrint) {
        $toPrint = '\t';
    }
    if ("\r" === $toPrint) {
        $toPrint = '\r';
    }
    if ("\n" === $toPrint) {
        $toPrint = '\n';
    }

    $code = $encoder->getLetterCode($letter);
    if (9 === strLen($code) && false === $moreThan8Bit) {
        echo '-------------------------', PHP_EOL;
        $moreThan8Bit = true;
    }

    if (17 === strLen($code) && false === $moreThan16Bit) {
        echo '-------------------------', PHP_EOL;
        $moreThan16Bit = true;
    }

    echo sprintf("%s\t%30s\t%30d\n", $toPrint, $code, $stats->getLetterCount($letter));
}

echo 'Done';
