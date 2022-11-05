<?php

namespace App;

use App\Models\Item;
use App\Models\ItemFactory;

class GildedRose
{
    private Item $item;

    public function __construct(Item $item)
    {
        $this->item = $item;
    }

    public static function of($name, $quality, $sellIn): static
    {
        return new static(ItemFactory::create($name, $quality, $sellIn));
    }

    public function tick()
    {
        $this->item->ageByOneDay();
    }

    /**
     * @return Item
     */
    public function item(): Item
    {
        return $this->item;
    }
}
