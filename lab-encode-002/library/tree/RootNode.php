<?php

declare(strict_types=1);

require_once __DIR__  . '/Node.php';

class RootNode extends Node
{
    public function __construct(int $weight)
    {
        parent::__construct($weight);
    }
}