<?php

namespace Dewsign\NovaBlog\Http\Controllers;

use Illuminate\Routing\Controller;
use Dewsign\NovaBlog\Models\Article;
use Illuminate\Support\Facades\View;
use Dewsign\NovaBlog\Models\Category;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BlogController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
    * Show all blog articles.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $articles = app(config('novablog.models.article', Article::class))::published()->includeRepeaters()->active()
            ->has('categories')
            ->orderBy('published_date', 'desc')
            ->paginate(config('novablog.pageSize', 12));

        $categories = app(config('novablog.models.category', Category::class))::has('articles')
            ->active()
            ->get();

        return View::first([
            'blog.index',
            'nova-blog::index',
        ])
        ->with('articles', $articles)
        ->with('categories', $categories)
        ->with('page', [
            'canonical' => \Maxfactor::urlWithQuerystring(route('blog.index'), $allowedParameters = 'page=[^1]')
        ]);
    }

    /**
     * Display a list of articles within a category.
     *
     * @param  string $category
     * @return \Illuminate\Http\Response
     */
    protected function list(string $category)
    {
        $category = app(config('novablog.models.category', Category::class))::whereSlug($category)->firstOrFail();

        $categories = app(config('novablog.models.category', Category::class))::has('articles')->get();

        // All recipes within current category
        $articles = $category
            ->articles()
            ->active()
            ->published()
            ->orderBy('published_date', 'desc')
            ->paginate(config('novablog.pageSize', 12));

        return View::first([
            'blog.list',
            'nova-blog::list',
        ])
        ->with('page', $category)
        ->with('articles', $articles)
        ->with('categories', $categories)
        ->with('category', $category)
        ->whenActive($category);
    }

    /**
     * This route handles both article details and categories.
     * It will internally call the list() method if no article
     * is found with a specific slug.
     *
     * @param string $category
     * @param string $article
     * @return \Illuminate\Http\Response
     */
    public function show(string $category, string $article)
    {
        $category = app(config('novablog.models.category', Category::class))::whereSlug($category)->firstOrFail();
        $article = app(config('novablog.models.article', Article::class))::includeRepeaters()
            ->whereSlug($article)
            ->whereHas('categories', function ($query) use ($category) {
                $query->where('id', '=', $category->id);
            })
            ->firstOrFail();

        $categories = app(config('novablog.models.category', Category::class))::has('articles')->get();

        $articles = app(config('novablog.models.category', Category::class))::inRandomOrder()->take(3)->get();

        return View::first([
            'blog.show',
            'nova-blog::show',
        ])
        ->with('page', $article)
        ->with('articles', $articles)
        ->with('categories', $categories)
        ->with('category', $category)
        ->whenActive($article);
    }
}
