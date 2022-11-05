<?php

declare(strict_types=1);

require_once __DIR__  . '/Helper.php';
require_once __DIR__  . '/ByteBuffer.php';
require_once __DIR__  . '/Stats.php';
require_once __DIR__  . '/TreeBuilder.php';
require_once __DIR__  . '/CodeSearcher.php';

class TreeEncoder
{
    private ?int $size;

    private readonly CodeSearcher $codeSearcher;

    protected ByteBuffer $buffer;

    public function __construct(
        private readonly NodeInterface $tree,
    )
    {
        $this->codeSearcher = new CodeSearcher($this->tree);
        $this->buffer = new ByteBuffer();
    }

    public function encode(string $sourceFileName, string $targetFileName): void
    {
        $fin = fopen($sourceFileName, 'r');
        $this->size = filesize($sourceFileName);

        while (!feof($fin)) {
            $line = fgets($fin);
            if (false === $line) {
                continue;
            }

            foreach (Helper::getUtfLetters($line) as $letter) {
                $this->buffer->append(
                    $this->codeSearcher->getCode($letter) //поиск кода по дереву
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

    protected function createFile(string $fileName)
    {
        return fopen($fileName, 'w');
    }

    protected function writeHeader($resource): void
    {
        $align = $this->buffer->align();
        $this->tree->setWeight($align);

        if ($this->tree instanceof RootNode) {
            $this->tree->setSize($this->size);
        }

        fwrite($resource, json_encode($this->tree) . PHP_EOL);
    }

    protected function writeBody($resource): void
    {
        $this->buffer->write($resource);
    }
}
