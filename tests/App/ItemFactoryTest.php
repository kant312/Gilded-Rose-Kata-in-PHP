<?php

namespace App;

use App\Models\Item;
use App\Models\ItemFactory;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Models\ItemFactory
 */
class ItemFactoryTest extends TestCase
{
    public function test_it_creates_an_item()
    {
        $item = ItemFactory::create('test', 1, 1);
        self::assertInstanceOf(Item::class, $item);
    }

    public function test_it_creates_backstage_concert()
    {
        $backstageConcert = ItemFactory::create(ItemFactory::BACKSTAGE_CONCERT, 1, 1);
        self::assertInstanceOf(Item::class, $backstageConcert);
    }

    public function test_it_creates_aged_brie()
    {
        $agedBrie = ItemFactory::create(ItemFactory::AGED_BRIED, 1, 1);
        self::assertInstanceOf(Item::class, $agedBrie);
    }

    public function test_it_creates_sulfura()
    {
        $sulfura = ItemFactory::create(ItemFactory::SULFURAS_HAND_OF_RAGNAROS, 1, 1);
        self::assertInstanceOf(Item::class, $sulfura);
    }
}
