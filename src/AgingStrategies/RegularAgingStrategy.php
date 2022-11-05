<?php

namespace App\AgingStrategies;

use App\Models\Item;

final class RegularAgingStrategy implements AgingStrategy
{
    public function ageByOneDay(Item $item): void
    {
        $item->adjustSellInBy(-1);
        $item->adjustQualityBy($item->sellInDayPassed() ? -2 : -1);
    }
}