<?php

namespace Dewsign\NovaBlog;

use Dewsign\NovaBlog\Models\Article;
use Dewsign\NovaBlog\Models\Category;

class NovaBlog
{
    public static function sitemap($sitemap)
    {
        static::addIndex($sitemap);
        static::addCategories($sitemap);
        static::addArticles($sitemap);
    }

    private static function addIndex($sitemap)
    {
        $sitemap->add(route('blog.index'));
    }

    private static function addCategories($sitemap)
    {
        Category::active()->has('articles')->get()->each(function ($category) use ($sitemap) {
            $sitemap->add(route('blog.list', $category));
        });
    }

    private static function addArticles($sitemap)
    {
        Article::active()->has('categories')->get()->each(function ($article) use ($sitemap) {
            $sitemap->add(route('blog.show', [$article->primaryCategory, $article]));
        });
    }
}
