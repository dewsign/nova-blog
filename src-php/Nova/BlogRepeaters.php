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
use Dewsign\NovaRepeaterBlocks\Repeaters\Common\Blocks\MarkdownBlock;

class BlogRepeaters extends Repeater
{
    /**
     * We do not want to include this in global searches because the parent repeater
     * is already included and this would cause duplication.
     *
     * @var bool
     */
    public static $globallySearchable = false;

    public static function morphTo()
    {
        return [
            config('novablog.resources.article', Article::class),
            config('novablog.resources.category', Category::class),
        ];
    }

    // What type of repeater blocks should be made available
    public function types(Request $request)
    {
        if (config('novablog.replaceRepeaters', false)) {
            return config('novablog.repeaters');
        }

        return array_merge([
            CustomViewBlock::class,
            ImageBlock::class,
            TextBlock::class,
            TextareaBlock::class,
            MarkdownBlock::class,
        ], config('novablog.repeaters'));
    }
}
