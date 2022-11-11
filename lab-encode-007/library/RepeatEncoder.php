<?php

declare(strict_types=1);

class RepeatEncoder
{
    public function __construct(
        private readonly int $repeat = 3
    )
    {
    }

    public function encode(string $word): string
    {
        $result = '';
        $length = strlen($word);

        for ($i = 0; $i < $length; ++$i) {
            $bit = $word[$i];
            $result .= str_repeat($bit, $this->repeat);
        }

        return $result;
    }

    public function messUp(string $word): string
    {
        $result = '';
        $length = strlen($word);

        for ($i = 0; $i < $length; ++$i) {
            $char = $word[$i];
            $test = rand(0, 1) > .25;

            if ('1' === $char) {
                $result .= $test ? $char : '0';
            } else {
                $result .= $test ? $char : '1';
            }
        }

        return $result;
    }

    public function decode(string $word): string
    {
        $result = '';
        $length = strlen($word);

        for ($i = 0; $i < $length; $i += $this->repeat) {
            $sum = 0;
            for ($j = 0; $j < $this->repeat; ++$j) {
                $sum += (int)$word[$i +$j];
            }

            $result .= $sum < ($this->repeat / 2) ? '0' : '1';
        }

        return $result;
    }
}
