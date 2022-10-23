<?php

declare(strict_types=1);

require_once __DIR__  . '/tree/NodeInterface.php';
require_once __DIR__  . '/CodeSearcher.php';
require_once __DIR__  . '/TreeBuilder.php';
require_once __DIR__  . '/BinaryDataParser.php';

class ShFaDecoder
{

    private readonly TreeBuilder $treeBuilder;
    public function __construct()
    {
        $this->treeBuilder = new TreeBuilder();
    }

    public function decode(string $sourceFileName, string $targetFileName): void
    {
        $fin = fopen($sourceFileName, 'r');

        $tree = $this->readTree($fin);

        $binaryData = '';
        while (!feof($fin)) {
            $char = fgetc($fin);
            if (!$char) {
                continue;
            }

            $byte= str_pad(decbin(ord($char)), 8, '0', STR_PAD_LEFT);
            $binaryData .= $byte;
        }

        fclose($fin);

        $parser = new BinaryDataParser($tree, $binaryData);

        $fout = fopen($targetFileName, 'w');
        fwrite($fout, $parser->parse());
        fclose($fout);
    }

    private function readTree($file): ?NodeInterface
    {
        $json = fgets($file);
        $data = json_decode($json);

        return $this->treeBuilder->restoreFromJson($data);
    }

    private function parseBinaryData(NodeInterface $tree, string $binaryData): void
    {
        $count = strlen($binaryData);
        for ($cursor = 0; $cursor < $count; ++$cursor) {
            $bite = $binaryData[$cursor];
        }
    }
}
