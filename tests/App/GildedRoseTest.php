<?php

namespace App;

use App\Models\ItemFactory;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\GildedRose::tick
 * @covers \App\GildedRose::of
 */
class GildedRoseTest extends TestCase
{
    public function test_sell_in_decreases_after_one_day(): void
    {
        $sellIn = 2;
        $gildedRose = GildedRose::of(...$this->makeItem(1, $sellIn));
        $gildedRose->tick();
        self::assertTrue($gildedRose->item()->getSellIn() === ($sellIn - 1));
    }

    public function test_quality_decreases_after_one_day()
    {
        $quality = 2;
        $gildedRose = GildedRose::of(...$this->makeItem($quality, 1));
        $gildedRose->tick();
        self::assertEquals($quality-1, $gildedRose->item()->getQuality());
    }

    public function test_quality_degrades_twice_as_fast_when_sell_in_over()
    {
        $gildedRose = GildedRose::of(...$this->makeItem(3, 1));
        $gildedRose->tick();
        self::assertEquals(2, $gildedRose->item()->getQuality());
        $gildedRose->tick();
        self::assertEquals(0, $gildedRose->item()->getQuality());
    }

    public function test_quality_varies_for_backstage_convert()
    {
        $gildedRose = GildedRose::of(...$this->makeItem(4, 11, ItemFactory::BACKSTAGE_CONCERT));
        $gildedRose->tick();
        self::assertEquals(5, $gildedRose->item()->getQuality());
        $gildedRose->tick();
        self::assertEquals(7, $gildedRose->item()->getQuality());

        $gildedRose = GildedRose::of(...$this->makeItem(4, 5, ItemFactory::BACKSTAGE_CONCERT));
        $gildedRose->tick();
        self::assertEquals(7, $gildedRose->item()->getQuality());

        $gildedRose = GildedRose::of(...$this->makeItem(4, 0, ItemFactory::BACKSTAGE_CONCERT));
        $gildedRose->tick();
        self::assertEquals(0, $gildedRose->item()->getQuality());
    }

    public function test_aged_brie_increases_in_quality_as_it_ages(): void
    {
        $gildedRose = GildedRose::of(...$this->makeItem(4, 2, ItemFactory::AGED_BRIED));
        $gildedRose->tick();
        self::assertEquals(5, $gildedRose->item()->getQuality());
    }

    public function test_conjured_item_quality_degrade_twice_as_fast(): void
    {
        $gildedRose = GildedRose::of(...$this->makeItem(10, 4, ItemFactory::CONJURED));
        $gildedRose->tick();
        self::assertEquals(8, $gildedRose->item()->getQuality());
    }

    public function test_quality_cannot_be_initialized_over_50(): void
    {
        $gildedRose = GildedRose::of(...$this->makeItem(51, 1));
        self::assertEquals(50, $gildedRose->item()->getQuality());
    }

    public function test_quality_never_goes_above_50(): void
    {
        $gildedRose = GildedRose::of(...$this->makeItem(50, 1, ItemFactory::AGED_BRIED));
        $gildedRose->tick();
        self::assertEquals(50, $gildedRose->item()->getQuality());
    }

    public function test_sulfuras_never_have_to_be_sold_and_keep_their_quality()
    {
        $gildedRose = GildedRose::of(...$this->makeItem(80,5, ItemFactory::SULFURAS_HAND_OF_RAGNAROS));
        $gildedRose->tick();
        self::assertEquals(80, $gildedRose->item()->getQuality());
        self::assertEquals(5, $gildedRose->item()->getSellIn());
    }

    public function test_backstage_passes_increase_in_quality_as_sell_in_decreases()
    {
        $gildedRose = GildedRose::of(...$this->makeItem(1, 1, ItemFactory::BACKSTAGE_CONCERT));
        $gildedRose->tick();
        self::assertEquals(4, $gildedRose->item()->getQuality());
    }

    public function makeItem(int $quality, int $sellIn, $name = 'test'): array
    {
        return [$name, $quality, $sellIn];
    }
}
