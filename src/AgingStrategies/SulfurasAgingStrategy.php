<?php

namespace App\AgingStrategies;

use App\Models\Item;

final class SulfurasAgingStrategy implements AgingStrategy
{
    public function ageByOneDay(Item $item): void
    {
        // Nothing to do as it's a legendary item, its sellIn and quality never change
    }
}