<?php

declare(strict_types=1);

require_once __DIR__ . '/LzWindow.php';
require_once __DIR__ . '/../../lab-encode-002/library/Helper.php';

class LzEncoder
{
    private readonly LzWindow $window;

    public function __construct(
        int $dictionaryLength,
        int $bufferLength,
    )
    {
        $this->window = new LzWindow($dictionaryLength, $bufferLength);
    }

    public function encode(string $inputFile, string $outputFile): void
    {
        $letters = $this->getLettersFromFile($inputFile);

        while (!empty($letters)) {
            $this->window->pushChar(array_shift($letters));
        }
        $this->window->finalize();

        echo $this->window->getCodes(), PHP_EOL;
    }

    protected function getLettersFromFile(string $inputFile): array
    {
        $result = [];

        $fin = fopen($inputFile, 'r');
        while (!feof($fin)) {
            $line = fgets($fin);
            if (false === $line) {
                continue;
            }

            foreach (Helper::getUtfLetters($line) as $letter) {
                $result[] = $letter;
            }
        }
        fclose($fin);

        return $result;
    }
}
