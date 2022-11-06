<?php

declare(strict_types=1);

require_once __DIR__ . '/LzDictionary.php';
require_once __DIR__ . '/LzBuffer.php';
require_once __DIR__ . '/LzCodes.php';

class LzWindow
{
    private readonly LzDictionary $dictionary;
    private readonly LzBuffer $buffer;
    private readonly LzCodes $lz;

    private ?LzCode $currentCode = null;

    public function __construct(
        int $dictionaryLength,
        int $bufferLength,
    )
    {
        $this->dictionary = new LzDictionary($dictionaryLength);
        $this->buffer = new LzBuffer($bufferLength);
        $this->lz = new LzCodes();
    }

    public function pushChar(string $char): void
    {
        if (false === $this->buffer->isFull()) {
            $this->buffer->pushChar($char);
            return;
        }

        $this->currentCode = null;
        $first = $this->buffer->shiftChar();
        $this->buffer->pushChar($char);
        $this->readLzCode($first);
    }

    public function finalize(): void
    {
        while ($this->buffer->getCurrentLength() > 0) {
            $this->lz->addCode(new LzCode($this->buffer->shiftChar(), 0, 0));
        }
    }

    public function getCodes(): LzCodes
    {
        return $this->lz;
    }

    protected function readLzCode(string $char): void
    {
        $offset = $this->dictionary->contains($char);

        if (false === $offset) {
            $this->lz->addCode(new LzCode($char, 0, 0));
            $this->dictionary->pushChar($char);
            return;
        }

        $substring = $char;
        while ($offset === $this->dictionary->contains($substring)) {
            $char = $this->buffer->shiftChar();
            $this->currentCode = new LzCode(
                $char,
                $offset,
                $this->currentCode?->getLength() + 1,
            );

            $substring .= $char;
        }

        $this->dictionary->pushSubstring($substring);

        $this->lz->addCode($this->currentCode);
        $this->currentCode = null;
    }
}
