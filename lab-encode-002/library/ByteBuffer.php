<?php

declare(strict_types=1);

class ByteBuffer
{
    private const BYTE = 8;

    private string $buffer = '';

    public function append(string $binaryCode): void
    {
        $this->buffer .= $binaryCode;
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
