<?php

declare(strict_types=1);

require_once __DIR__  . '/Stats.php';
require_once __DIR__  . '/tree/RootNode.php';

class TreePrinter
{
    private CodeSearcher $codeSearcher;

    public function __construct(private readonly NodeInterface $tree)
    {
        $this->codeSearcher = new CodeSearcher($this->tree);
    }

    public function print(Stats $stats): void
    {
        $moreThan8Bit = false;
        $moreThan16Bit = false;
        foreach ($stats->getLetters() as $letter) {
            $toPrint = $letter;
            if ("\t" === $toPrint) {
                $toPrint = '\t';
            }
            if ("\r" === $toPrint) {
                $toPrint = '\r';
            }
            if ("\n" === $toPrint) {
                $toPrint = '\n';
            }

            $code = $this->codeSearcher->getCode((string)$letter);
            if (9 === strLen($code) && false === $moreThan8Bit) {
                echo '-------------------------', PHP_EOL;
                $moreThan8Bit = true;
            }

            if (17 === strLen($code) && false === $moreThan16Bit) {
                echo '-------------------------', PHP_EOL;
                $moreThan16Bit = true;
            }

            echo sprintf("%s\t%-30s\t%30d\n", $toPrint, $code, $stats->getLetterCount((string)$letter));
        }
    }
}
