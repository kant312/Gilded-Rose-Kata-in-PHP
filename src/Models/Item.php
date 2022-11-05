<?php

namespace App\Models;

use App\AgingStrategies\AgingStrategy;
use App\ValueObjects\Quality;
use App\ValueObjects\SellIn;

final class Item
{
    readonly private string $name;
    private SellIn $sellIn;
    private Quality $quality;
    private AgingStrategy $agingStrategy;

    public function __construct(string $name, Quality $quality, SellIn $sellIn, AgingStrategy $agingStrategy)
    {
        $this->name = $name;
        $this->quality = $quality;
        $this->sellIn = $sellIn;
        $this->agingStrategy = $agingStrategy;
    }

    public static function from(string $name, Quality $quality, SellIn $sellIn, AgingStrategy $agingStrategy)
    {
        return new static($name, $quality, $sellIn, $agingStrategy);
    }

    public function getQuality(): int
    {
        return $this->quality->asInt();
    }

    public function getSellIn(): int
    {
        return $this->sellIn->asInt();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function adjustQualityBy(int $amount): self
    {
        $this->quality = $this->quality->adjustBy($amount);
        return $this;
    }

    public function adjustSellInBy($amount): self
    {
        $this->sellIn = $this->sellIn->adjustBy($amount);
        return $this;
    }

    public function ageByOneDay(): void
    {
        $this->agingStrategy->ageByOneDay($this);
    }

    public function sellInDayPassed()
    {
        return $this->getSellIn() < 0;
    }
}