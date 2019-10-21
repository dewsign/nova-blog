<?php

use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Dewsign\NovaBlog\Models\Article;

$factory->define(config('novablog.models.article', Article::class), function (Faker $faker) {
    return [
        'active' => $faker->boolean(90),
        'featured' => $faker->boolean(20),
        'name' => $name = "{$faker->company} {$faker->bs}",
        'slug' => Str::slug($name),
        'image' => $faker->boolean(80) ? $faker->imageUrl($width = 640, $height = 480, 'business') : null,
        'summary' => $faker->realText(rand(70, 500)),
        'priority' => $faker->numberBetween(1, 100),
        'published_date' => $faker->dateTimeBetween($startDate = '-1 month', $endDate = '+1 month'),
    ];
});
