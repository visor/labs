<?php

require_once __DIR__  . '/library/Counter.php';
require_once __DIR__  . '/library/TreeBuilder.php';
require_once __DIR__  . '/library/TreePrinter.php';
require_once __DIR__  . '/library/ShFaEncoder.php';

$inputFile = __DIR__ . '/../lab-encode-texts/' . $argv[1];
$outputFile = __DIR__ . '/encoded/' . $argv[2];

$stats = (new Counter)->countFile($inputFile); // собираем статистику
$tree = (new TreeBuilder())->build($stats); // строим дерево по статистике

(new TreePrinter($tree))->print($stats); // выводим дерево со статистикой

(new ShFaEncoder($stats))->encode($inputFile, $outputFile); // кодируем

echo 'Done';
