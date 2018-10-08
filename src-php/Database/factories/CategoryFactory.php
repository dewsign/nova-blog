<?php

use Faker\Generator as Faker;
use Dewsign\NovaBlog\Models\Category;

$factory->define(Category::class, function (Faker $faker) {
    return [
        'active' => $faker->boolean(90),
        'featured' => $faker->boolean(20),
        'name' => $name = $faker->unique()->randomElement(
            collect([])->times(42, function () use ($faker) {
                return sprintf('%s %s', $faker->randomElement([
                    'Useful',
                    'Interesting',
                    'Exciting',
                    'Must read',
                    'Delightful',
                    'Latest',
                    'Popular',
                ]), $faker->randomElement([
                    'news',
                    'articles',
                    'posts',
                    'words',
                    'feelings',
                    'emotions',
                ]));
            })->all()
        ),
        'slug' => str_slug($name),
        'image' => $faker->boolean(80) ? $faker->imageUrl($width = 640, $height = 480, 'business') : null,
    ];
});
