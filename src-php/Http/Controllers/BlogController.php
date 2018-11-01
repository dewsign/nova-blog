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
        $articles = Article::includeRepeaters()->active()
            ->orderBy('published_date', 'desc')
            ->paginate(config('novablog.pageSize', 12));

        $categories = Category::has('articles')
            ->active()
            ->get();

        return View::first([
            'blog.index',
            'nova-blog::index',
        ])
        ->with('articles', $articles)
        ->with('categories', $categories)
        ->with('page', [
            'canonical' => route('blog.index')
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
        $category = Category::whereSlug($category)->firstOrFail();

        $categories = Category::has('articles')->get();

        // All recipes within current category
        $articles = $category
            ->articles()
            ->orderBy('published_date', 'desc')
            ->paginate(12);

        return View::first([
            'blog.list',
            'nova-blog::list',
        ])
        ->with('page', $category)
        ->with('articles', $articles)
        ->with('categories', $categories)
        ->with('category', $category);
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
        $category = Category::whereSlug($category)->firstOrFail();
        $article = Article::includeRepeaters()->whereSlug($article)->firstOrFail();

        $categories = Category::has('articles')->get();

        $articles = Article::inRandomOrder()->take(3)->get();

        return View::first([
            'blog.show',
            'nova-blog::show',
        ])
        ->with('page', $article)
        ->with('articles', $articles)
        ->with('categories', $categories)
        ->with('category', $category);
    }
}
