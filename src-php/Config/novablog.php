<?php

return [
    'pageSize' => 12,
    'repeaters' => [],
    'replaceRepeaters' => false,
    'models' => [
        'article' => 'Dewsign\NovaBlog\Models\Article',
        'category' => 'Dewsign\NovaBlog\Models\Category',
        'author' => config('laravel-authors.user-model'),
    ],
    'resources' => [
        'article' => 'Dewsign\NovaBlog\Nova\Article',
        'category' => 'Dewsign\NovaBlog\Nova\Category',
        'author' => 'App\Nova\User',
    ],
    'group' => 'Blog',
    'images' => [
        'field' => 'Laravel\Nova\Fields\Image',
        'disk' => 'public',
    ],
];
