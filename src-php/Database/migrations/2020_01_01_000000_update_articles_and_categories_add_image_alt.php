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
            $table->string('alternative_text')->nullable()->after('image');
        });

        Schema::table('blog_articles', function (Blueprint $table) {
            $table->string('alternative_text')->nullable()->after('image');
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
            $table->dropColumn('alternative_text');
        });

        Schema::table('blog_articles', function (Blueprint $table) {
            $table->dropColumn('alternative_text');
        });
    }
}
