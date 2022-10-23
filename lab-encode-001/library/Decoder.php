<?php

require_once __DIR__ . '/Alphabet.php';
require_once __DIR__ . '/LetterCounter.php';
require_once __DIR__ . '/Replacer.php';

class Decoder
{
    private LetterCounter $counter;

    private Alphabet $source;
    private Alphabet $target;

    public function __construct(
        private readonly Alphabet $alphabet,
        private array $frequency,
    )
    {
        $this->counter = new LetterCounter($this->alphabet);
    }

    public function decodeFile(string $fileName): string
    {
        $result = '';
        $this->createKey($fileName);


        $replacer = new Replacer($this->source->getIterator(), $this->target->getIterator());

        $fin = fopen($fileName, 'r');

        while (!feof($fin)) {
            $line = trim(fgets($fin), PHP_EOL);

            $result .= $replacer->replace($line) . PHP_EOL;
        }

        fclose($fin);
        return $result;
    }

    public function getSource(): Alphabet
    {
        return $this->source;
    }

    public function getTarget(): Alphabet
    {
        return $this->target;
    }

    protected function createKey(string $fileName): void
    {
        $keyFile = $fileName . '.key.decode';
        if (file_exists($keyFile)) {
            $lines = trim(file_get_contents($keyFile), PHP_EOL);
            [$source, $target] = explode(PHP_EOL, $lines, 2);

            $this->source = new Alphabet($source);
            $this->target = new Alphabet($target);
            return;
        }

        uasort($this->frequency, function ($a, $b) {
            return ($a['index'] < $b['index']) ? 1 : -1;
        });

        $this->counter->countFile($fileName);

        $sourceFrequency = $this->frequencyToIndex($this->counter->toArray());
        $targetFrequency = $this->frequencyToIndex($this->frequency);

        $source = implode('', $sourceFrequency);
        $target = implode('', $targetFrequency);
        file_put_contents($keyFile, $source . PHP_EOL . $target);

        $this->source = new Alphabet($source);
        $this->target = new Alphabet($target);
    }

    protected function frequencyToIndex(array $frequency): array
    {
        $result = [];
        foreach ($frequency as $letter => $data) {
            $result[$data['index']] = $letter;
        }

        ksort($result);
        return $result;
    }
}
