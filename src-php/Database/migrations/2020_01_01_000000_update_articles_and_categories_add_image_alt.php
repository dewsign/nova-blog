<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateArticlesAndCategoriesAddImageAlt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blog_categories', function (Blueprint $table) {
            $table->text('image_alt')->nullable()->after('image');
        });

        Schema::table('blog_articles', function (Blueprint $table) {
            $table->text('image_alt')->nullable()->after('image');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blog_categories', function (Blueprint $table) {
            $table->dropColumn('image_alt');
        });

        Schema::table('blog_articles', function (Blueprint $table) {
            $table->dropColumn('image_alt');
        });
    }
}
