<?php

namespace App\AgingStrategies;

use App\Models\Item;

final class BackstageConcertAgingStrategy implements AgingStrategy
{
    public function ageByOneDay(Item $item): void
    {
        // Quality increases depending on sell in
        $sellIn = $item->getSellIn();
        $qualityIncreaseAmount = match (true) {
            $sellIn <= 5 => 3,
            $sellIn <= 10 => 2,
            $sellIn > 10 => 1,
        };
        $item->adjustQualityBy($qualityIncreaseAmount);
        $item->adjustSellInBy(-1);

        // When the concert is over, quality drops to 0
        if ($item->sellInDayPassed()) {
            $item->adjustQualityBy(-$item->getQuality());
        }
    }
}