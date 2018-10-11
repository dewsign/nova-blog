<?php

namespace Dewsign\NovaBlog\Nova;

use Illuminate\Http\Request;
use Dewsign\NovaBlog\Nova\Article;
use Dewsign\NovaBlog\Nova\Category;
use Dewsign\NovaRepeaterBlocks\Fields\Repeater;
use Dewsign\NovaRepeaterBlocks\Repeaters\Common\Blocks\CustomViewBlock;
use Dewsign\NovaRepeaterBlocks\Repeaters\Common\Blocks\TextBlock;
use Dewsign\NovaRepeaterBlocks\Repeaters\Common\Blocks\ImageBlock;
use Dewsign\NovaRepeaterBlocks\Repeaters\Common\Blocks\TextareaBlock;

class Repeaters extends Repeater
{
    // One or more Nova Resources which use this Repeater
    public static $morphTo = [
        Article::class,
        Category::class,
    ];

    // What type of repeater blocks should be made available
    public function types(Request $request)
    {
        return [
            CustomViewBlock::class,
            ImageBlock::class,
            TextBlock::class,
            TextareaBlock::class,
        ];
    }
}
