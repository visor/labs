<?php

declare(strict_types=1);

interface NodeInterface extends JsonSerializable
{
    public function getParent(): ?NodeInterface;

    public function setParent(?NodeInterface $node = null): void;

    public function getLetter(): ?string;

    public function setWeight(?int $weight): void;

    public function getWeight(): int;

    public function getCode(): ?int;

    public function getFullCode(): ?string;

    public function setCode(?int $code): void;

    public function setLeft(?NodeInterface $left): void;

    public function getLeft(): ?NodeInterface;

    public function setRight(?NodeInterface $right): void;

    public function getRight(): ?NodeInterface;

    public function isLeaf(): bool;

    public function searchByLetter(string $letter): ?NodeInterface;

    public function searchByCode(string $code): ?NodeInterface;
}
