<?php

declare(strict_types=1);

class Helper
{
    /**
     * Метод возвращает массив UTF-8 символов, которые содержатся в переданной строке.
     */
    public static function getUtfLetters(string $string): array
    {
        return preg_split('//u', $string, -1, PREG_SPLIT_NO_EMPTY);
    }
}
