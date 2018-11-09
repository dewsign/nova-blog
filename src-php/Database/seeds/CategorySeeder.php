<?php

namespace Dewsign\NovaBlog\Database\Seeds;

use Illuminate\Database\Seeder;
use Dewsign\NovaBlog\Models\Category;
use Dewsign\NovaRepeaterBlocks\Models\Repeater;
use Dewsign\NovaRepeaterBlocks\Repeaters\Common\AvailableBlocks;
use Dewsign\NovaRepeaterBlocks\Repeaters\Common\Models\TextBlock;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(config('novablog.models.category', Category::class), 10)->create()->each(function ($category) {
            $category->repeaters()->saveMany(factory(Repeater::class, 5)->create()->each(function ($repeater) {
                $repeater->type()->associate(factory(AvailableBlocks::random())->create())->save();
            }));
        });
    }
}
