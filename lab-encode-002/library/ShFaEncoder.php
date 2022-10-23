<?php

declare(strict_types=1);

require_once __DIR__  . '/Helper.php';
require_once __DIR__  . '/ByteBuffer.php';
require_once __DIR__  . '/Stats.php';
require_once __DIR__  . '/TreeBuilder.php';
require_once __DIR__  . '/CodeSearcher.php';

class ShFaEncoder
{
    private readonly NodeInterface $tree;

    private readonly CodeSearcher $codeSearcher;

    private readonly ByteBuffer $buffer;

    public function __construct(
        private readonly Stats $stats,
    )
    {
        $this->tree = (new TreeBuilder())->build($this->stats);
        $this->codeSearcher = new CodeSearcher($this->tree);
        $this->buffer = new ByteBuffer();
    }

    public function encode(string $sourceFileName, string $targetFileName): void
    {
        $fin = fopen($sourceFileName, 'r');

        while (!feof($fin)) {
            $line = fgets($fin);
            if (false === $line) {
                continue;
            }

            foreach (Helper::getUtfLetters($line) as $letter) {
                $this->buffer->append(
                    $this->codeSearcher->getCode($letter)
                );
            }
        }

        fclose($fin);

        $this->writeToFile($targetFileName);
    }

    public function writeToFile(string $fileName): void
    {
        $resource = $this->createFile($fileName);
        $this->writeHeader($resource);
        $this->writeBody($resource);

        fclose($resource);
    }

    private function createFile(string $fileName)
    {
        return fopen($fileName, 'w');
    }

    private function writeHeader($resource): void
    {
        $zeros = ByteBuffer::BYTE + ($this->buffer->getLength() % ByteBuffer::BYTE);
        $this->buffer->align($zeros);
        $this->tree->setWeight($zeros);

        fwrite($resource, json_encode($this->tree) . PHP_EOL);
    }

    private function writeBody($resource): void
    {
        $this->buffer->write($resource);
    }
}
