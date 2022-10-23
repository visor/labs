<?php

declare(strict_types=1);

class ByteBuffer
{
    public const BYTE = 8;

    private string $buffer = '';

    public function append(string $binaryCode): void
    {
        $this->buffer .= $binaryCode;
    }

    public function align(): int
    {
        $result = 0;

        while (0 !== $this->getLength() % self::BYTE) {
            ++$result;
            $this->buffer = '0' . $this->buffer;
        }

        return $result;
    }

    public function getLength(): int
    {
        return strLen($this->buffer);
    }

    public function write($file): void
    {
        $count = strLen($this->buffer);

        for ($i = 0; $i < $count; $i+= self::BYTE) {
            $byte = bindec($this->getByteAt($i));
            fwrite($file, chr($byte));
        }
    }

    public function getByteAt(int $index): string
    {
        return substr($this->buffer, $index, self::BYTE);
    }
}
