<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogArticleBlogCategoryPivot extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_article_blog_category', function (Blueprint $table) {
            $table->integer('article_id')->unsigned()->index();
            $table->foreign('article_id')->references('id')->on('blog_articles')->onDelete('cascade');
            $table->integer('category_id')->unsigned()->index();
            $table->foreign('category_id')->references('id')->on('blog_categories')->onDelete('cascade');
            $table->primary(['article_id', 'category_id'], 'article_category_primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_article_blog_category');
    }
}
