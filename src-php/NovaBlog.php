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

        $articles = app(config('novablog.models.article', Article::class))::includeRepeaters()
            ->active()
            ->has('categories')
            ->orderBy('published_date', 'desc')
            ->paginate(config('novablog.pageSize', 12))
            ->setPath(route('blog.index'));

        for ($page = 2; $page <= $articles->lastPage(); $page ++) {
            $sitemap->add($articles->url($page));
        }
    }

    private static function addCategories($sitemap)
    {
        app(config('novablog.models.category', Category::class))::active()
            ->has('articles')
            ->get()
            ->each(function ($category) use ($sitemap) {
                $sitemap->add(route('blog.list', $category));

                $articles = $category
                    ->articles()
                    ->active()
                    ->orderBy('published_date', 'desc')
                    ->paginate(config('novablog.pageSize', 12))
                    ->setPath(route('blog.list', $category));

                for ($page = 2; $page <= $articles->lastPage(); $page ++) {
                    $sitemap->add($articles->url($page));
                }
            });
    }

    private static function addArticles($sitemap)
    {
        app(config('novablog.models.article', Article::class))::active()
            ->has('categories')
            ->get()
            ->each(function ($article) use ($sitemap) {
                $sitemap->add(route('blog.show', [$article->primaryCategory, $article]));
            });
    }
}
