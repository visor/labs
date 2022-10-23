<?php

class Replacer
{
    private readonly array $map;

    public function __construct(
        array $source,
        array $target,
    )
    {
        $this->prepareMap($source, $target);
    }

    public function replace(string $string): string
    {
        $result = '';
        $length = mb_strlen($string);

        for ($i = 0; $i < $length; ++$i) {
            $letter = mb_substr($string, $i, 1);
            $mapped = $this->map[$letter] ?? '?';

            $result .= $mapped;
        }

        return $result;
    }

    protected function prepareMap($source, $target): void
    {
        $this->map = array_combine($source, $target);
    }
}