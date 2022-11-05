<?php

namespace App\Models;

use App\AgingStrategies\BackstageConcertAgingStrategy;
use App\AgingStrategies\CheeseAgingStrategy;
use App\AgingStrategies\RegularAgingStrategy;
use App\AgingStrategies\SulfurasAgingStrategy;
use App\ValueObjects\Quality;
use App\ValueObjects\SellIn;

final class ItemFactory
{
    public const AGED_BRIED = 'Aged Brie';
    public const BACKSTAGE_CONCERT = 'Backstage passes to a TAFKAL80ETC concert';
    public const SULFURAS_HAND_OF_RAGNAROS = 'Sulfuras, Hand of Ragnaros';

    public static function create(string $name, int $quality, int $sellIn)
    {
        return match($name) {
            self::AGED_BRIED => Item::from(
                $name,
                Quality::ofRegularItem($quality),
                SellIn::fromInt($sellIn),
                new CheeseAgingStrategy()
            ),
            self::BACKSTAGE_CONCERT => Item::from(
                $name,
                Quality::ofRegularItem($quality),
                SellIn::fromInt($sellIn),
                new BackstageConcertAgingStrategy()
            ),
            self::SULFURAS_HAND_OF_RAGNAROS => Item::from(
                $name,
                Quality::ofSulfuras(),
                SellIn::fromInt($sellIn),
                new SulfurasAgingStrategy()
            ),
            default => Item::from(
                $name,
                Quality::ofRegularItem($quality),
                SellIn::fromInt($sellIn),
                new RegularAgingStrategy()
            ),
        };
    }
}