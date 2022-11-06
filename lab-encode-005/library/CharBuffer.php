<?php

declare(strict_types=1);

class CharBuffer
{
    private string $buffer = '';

    public function __construct(
        private readonly int $length
    )
    {
    }

    public function getChar($index): ?string
    {
        return mb_substr($this->buffer, $index, 1, 'UTF-8');
    }

    public function pushChar(string $char): ?string
    {
        $result = null;

        if ($this->isFull()) {
            $result = $this->shiftChar();
        }

        $this->buffer .= $char;
        return $result;
    }

    public function shiftChar(): string
    {
        $result = $this->getChar(0);
        $this->buffer = mb_substr($this->buffer, 1, null, 'UTF-8');

        return $result;
    }

    public function contains(string $substring): bool|int
    {
        $result = mb_strpos($this->buffer, $substring);

        if (false === $result) {
            return false;
        }

        return $result += $this->getLength() - $this->getCurrentLength();
    }

    public function isFull(): bool
    {
        return $this->getCurrentLength() === $this->getLength();
    }

    public function getCurrentLength(): int
    {
        return mb_strlen($this->buffer, 'UTF-8');
    }

    public function getLength(): int
    {
        return $this->length;
    }
}
