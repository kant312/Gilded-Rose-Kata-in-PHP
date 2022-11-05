<?php

namespace App\AgingStrategies;

use App\Models\Item;

interface AgingStrategy
{
    public function ageByOneDay(Item $item): void;
}