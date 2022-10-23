<?php

declare(strict_types=1);

class Helper
{
    public static function getUtfLetters(string $string): array
    {
        $result = preg_split('//u', $string, -1, PREG_SPLIT_NO_EMPTY);
        if (false === $result) {
            return str_split($string);
        }

        return $result;
    }
}
