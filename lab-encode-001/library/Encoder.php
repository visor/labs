<?php

require_once __DIR__ . '/Alphabet.php';
require_once __DIR__ . '/Replacer.php';

class Encoder
{
    public function __construct(
        private readonly Alphabet $alphabet,
        private readonly Alphabet $key
    )
    {
    }

    public function encodeFile(string $fileName): string
    {
        $fin = fopen($fileName, 'r');
        $result = '';

        $replacer = new Replacer($this->alphabet->getIterator(), $this->key->getIterator());

        while (!feof($fin)) {
            $line = trim(fgets($fin), PHP_EOL);

            $result .= $replacer->replace($line) . PHP_EOL;
        }

        fclose($fin);
        return $result;
    }
}
