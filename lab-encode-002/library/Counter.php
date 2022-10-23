<?php

declare(strict_types=1);

require_once __DIR__  . '/Helper.php';
require_once __DIR__  . '/Stats.php';
require_once __DIR__  . '/StatsPair.php';

class Counter
{
    public function countFile(string $fileName): Stats
    {
        $result = new Stats;

        $fin = fopen($fileName, 'r');
        while (false === feof($fin)) {
            $line = fgets($fin);
            if (false === $line) {
                continue;
            }

            foreach (Helper::getUtfLetters($line) as $letter) {
                $result->addLetter($letter);
            }
        }

        fclose($fin);
        return $result;
    }
}
