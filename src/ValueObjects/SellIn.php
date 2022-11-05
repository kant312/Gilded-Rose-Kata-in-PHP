<?php

namespace App\ValueObjects;

final class SellIn
{
    private function __construct(
        private readonly int $sellIn
    ) {}

    public static function fromInt(int $sellIn)
    {
        return new self($sellIn);
    }

    public function asInt(): int
    {
        return $this->sellIn;
    }

    public function adjustBy(int $amount): self
    {
        return self::fromInt($this->sellIn + $amount);
    }
}