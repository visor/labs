<?php

declare(strict_types=1);

require_once __DIR__ . '/LzCode.php';

class LzCodes
{
    public function __construct(
        private array $codes = [],
    )
    {
    }

    public function addCode(LzCode $code): void
    {
        $this->codes[] = $code;
    }

    public function getCodes(): array
    {
        return $this->codes;
    }

    public function __toString(): string
    {
        $result = '';

        foreach ($this->codes as $code) {
            $result .= (string)$code . PHP_EOL;
        }

        return $result;
    }

}
