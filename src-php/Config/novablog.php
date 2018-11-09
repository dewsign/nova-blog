<?php

return [
    'pageSize' => 12,
    'repeaters' => [],
    'replaceRepeaters' => false,
    'models' => [
        'article' => 'Dewsign\NovaBlog\Models\Article',
        'category' => 'Dewsign\NovaBlog\Models\Category',
    ],
    'resources' => [
        'article' => 'Dewsign\NovaBlog\Nova\Article',
        'category' => 'Dewsign\NovaBlog\Nova\Category',
    ],
    'group' => 'Blog',
    'images' => [
        'field' => 'Laravel\Nova\Fields\Image',
        'disk' => 'public',
    ],
];
