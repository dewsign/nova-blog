<?php

namespace Dewsign\NovaBlog\Database\Seeds;

use Illuminate\Database\Seeder;
use Dewsign\NovaBlog\Models\Article;
use Dewsign\NovaBlog\Models\Category;
use Dewsign\NovaRepeaterBlocks\Models\Repeater;
use Dewsign\NovaRepeaterBlocks\Repeaters\Common\AvailableBlocks;
use Dewsign\NovaRepeaterBlocks\Repeaters\Common\Models\TextBlock;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Article::class, 100)->create()->each(function ($article) {
            $article->repeaters()->saveMany(factory(Repeater::class, 5)->create()->each(function ($repeater) {
                $repeater->type()->associate(factory(AvailableBlocks::random())->create())->save();
            }));

            $article->categories()->attach(Category::inRandomOrder()->take(rand(1, 3))->get());
        });
    }
}
