<?php

namespace App\AgingStrategies;

use App\Models\Item;

final class ConjuredAgingStrategy implements AgingStrategy
{
    public function ageByOneDay(Item $item): void
    {
        $item->adjustSellInBy(-1);
        $item->adjustQualityBy(-2);
    }
}