<?php

namespace App\ValueObjects;

final class Quality
{
    private readonly int $maximum;
    private readonly int $minimum;
    private readonly int $quality;

    private function __construct(int $quality, int $minimum = 0, int $maximum = 50) {
        $this->minimum = $minimum;
        $this->maximum = $maximum;
        $this->quality = max($this->minimum, min($quality, $this->maximum));
    }

    public static function ofSulfuras(): self
    {
        return new self(80, 80, 80);
    }

    public static function ofRegularItem(int $quality): self
    {
        return new self($quality);
    }

    public function asInt(): int
    {
        return $this->quality;
    }

    public function adjustBy(int $amount): Quality
    {
        return new self($this->quality + $amount, $this->minimum, $this->maximum);
    }
}