<?php

declare(strict_types=1);

require_once __DIR__ . '/CharBuffer.php';

class LzDictionary extends CharBuffer
{
    public function pushSubstring(string $substring): void
    {
        $length = mb_strlen($substring, 'UTF-8');

        for ($i = 0; $i < $length; ++$i) {
            $this->pushChar(mb_substr($substring, $i, 1, 'UTF-8'));
        }
    }
}
