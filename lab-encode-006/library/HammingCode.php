<?php

declare(strict_types=1);

require_once __DIR__ . '/BitArray.php';

class HammingCode
{
    public function __construct(
        private readonly int $messageLength,
        private readonly int $dataLength,
        private readonly bool $verbose = true,
    )
    {
    }

    public function encode(BitArray $data): BitArray
    {
        if ($data->countBits() != $this->dataLength) {
            throw new RuntimeException('Incorrect data length');
        }

        $result = $this->fillResultFromData($data);
        if ($this->verbose) {
            echo '  ', $result, PHP_EOL;
        }

        $this->calculateChecksums($result);

        return $result;
    }

    public function decode(BitArray $message): BitArray
    {
        if ($message->countBits() != $this->messageLength) {
            throw new RuntimeException('Incorrect message length');
        }

        $copy = $message->copy();
        if ($this->verbose) {
            echo '--', $copy, PHP_EOL;
        }

        $correct = $this->correctError($message, $copy);

        return $this->fillResultFromMessage($correct);
    }

    protected function fillResultFromData(BitArray $data): BitArray
    {
        $result = BitArray::createEmpty($this->messageLength);

        $skipIndex = 1;
        $dataIndex = 0;
        for ($i = 0; $i < $this->messageLength; ++$i) {
            if ($i === $skipIndex - 1) {
                $skipIndex *= 2;
                continue;
            }

            $result->setBit($i, $data->getBit($dataIndex));
            ++$dataIndex;
        }

        return $result;
    }

    protected function fillResultFromMessage(BitArray $message): BitArray
    {
        $result = BitArray::createEmpty($this->dataLength);

        $skipIndex = 1;
        $dataIndex = 0;
        for ($i = 0; $i < $this->messageLength && $dataIndex < $this->dataLength; ++$i) {
            if ($i === $skipIndex - 1) {
                $skipIndex *= 2;
                continue;
            }

            $result->setBit($dataIndex, $message->getBit($i));
            ++$dataIndex;
        }

        return $result;
    }

    protected function calculateCheckSums(BitArray $result): void
    {
        $index = 1;
        while ($index < $this->messageLength) {
            $result->setBit($index - 1, null);
            $parityBits = $this->getParityBits($result, $index);
            $parity = $parityBits->countTrueBits() % 2;
            $result->setBit($index - 1, 1 === $parity);
            if ($this->verbose) {
                echo $index, ' ', $parityBits, PHP_EOL, '  ', $result, PHP_EOL;
            }
            $index *= 2;
        }
    }

    protected function getParityBits(BitArray $source, int $index): BitArray
    {
        $result = BitArray::createEmpty($this->messageLength);

        $i = $index - 1;
        while ($i < $this->messageLength) {
            for ($j = 0; $j < $index && $i < $this->messageLength; ++$j) {
                $result->setBit($i, $source->getBit($i));
                ++$i;
            }
            $i += $index;
        }

        return $result;
    }

    protected function correctError(BitArray $message, BitArray $check): BitArray
    {
        $this->calculateCheckSums($check);
        $result = $check->copy();
        if ($this->verbose) {
            echo '--', $result, PHP_EOL;
        }

        $indexes = [];
        for ($i = 1; $i < $this->messageLength; $i *= 2) {
            $index = $i - 1;
            if ($message->getBit($index) !== $check->getBit($index)) {
                $indexes[] = $i;
            }
        }

        if (empty($indexes)) {
            return $result;
        }

        $invalid = array_sum($indexes);
        $result->invertBit($invalid - 1);
        if ($this->verbose) {
            echo '--', $result, PHP_EOL;
        }

        return $result;
    }
}
