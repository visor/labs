<?php

declare(strict_types=1);

class BitArray
{
    public function __construct(
        private array $bits = []
    )
    {
    }

    public static function createEmpty(int $length): self
    {
        return new self(array_fill(0, $length, null));
    }

    public static function createFromString(string $data): self
    {
        $length = strlen($data);
        $bits = [];
        for ($i = 0; $i < $length; ++$i) {
            $bits[$i] = match ($data[$i]) {
                '1' => true,
                '0' => false,
                default => null
            };
        }

        return new self($bits);
    }

    public function setBit(int $index, ?bool $value = null): void
    {
        $this->bits[$index] = $value;
    }

    public function invertBit(int $index)
    {
        if (null === $this->getBit($index)) {
            return;
        }

        $this->bits[$index] = !$this->bits[$index];
    }

    public function getBit(int $index): ?bool
    {
        return $this->bits[$index] ?? null;
    }

    public function getBits(): array
    {
        return $this->bits;
    }

    public function countBits(): int
    {
        return count($this->bits);
    }

    public function countTrueBits(): int
    {
        $result = 0;

        foreach ($this->bits as $bit) {
            if (true === $bit) {
                ++$result;
            }
        }

        return $result;
    }

    public function copy(): self
    {
        return new self($this->bits);
    }

    public function __toString(): string
    {
        $result = '';

        foreach ($this->bits as $bit) {
            if (null === $bit) {
                $result .= '.';
                continue;
            }
            $result .= $bit ? '1' : '0';
        }

        return $result;
    }
}
