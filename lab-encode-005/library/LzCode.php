<?php

declare(strict_types=1);

class LzCode
{
    public function __construct(
        private readonly string $char,
        private readonly ?int $offset = null,
        private readonly ?int $length = null,
    )
    {
    }

    public function getChar(): string
    {
        return $this->char;
    }

    public function getOffset(): ?int
    {
        return $this->offset;
    }

    public function getLength(): ?int
    {
        return $this->length;
    }

    public function __toString(): string
    {
        return '<' . $this->offset . ', ' . $this->length . ', ' . $this->char . '>';
    }
}
