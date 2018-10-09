<?php

namespace Dewsign\NovaBlog\Tests;

use Dewsign\NovaBlog\Models\Article;
use Dewsign\NovaBlog\Models\Category;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class BlogTest extends TestCase
{
    public function testBlogIndexIsAccessible()
    {
        $result = $this->get(route('blog.index'));
        $result->assertOk();
    }

    public function testBlogIndexShowsCategories()
    {
        $result = $this->get(route('blog.index'));
        $result->assertSee(Category::active()->first()->navTitle);
    }

    public function testBlogCategoryIsAccessible()
    {
        $result = $this->get(route('blog.list', Category::active()->first()));
        $result->assertOk();
    }

    public function testBlogArticleIsAccessible()
    {
        $blog = Article::has('categories')->active()->first();

        $result = $this->get(route('blog.show', [$blog->primaryCategory, $blog]));
        $result->assertOk();
    }
}
