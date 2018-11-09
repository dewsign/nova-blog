<?php
namespace Dewsign\NovaBlog\Nova;

use Laravel\Nova\Nova;
use Dewsign\NovaBlog\Nova\Article;
use Laravel\Nova\Tool as NovaTool;
use Dewsign\NovaBlog\Nova\Category;

class NovaBlogTool extends NovaTool
{
    /**
     * Perform any tasks that need to happen when the tool is booted.
     *
     * @return void
     */
    public function boot()
    {
        Nova::resources([
            config('novablog.resources.article', Article::class),
            config('novablog.resources.category', Category::class),
        ]);
    }
}
