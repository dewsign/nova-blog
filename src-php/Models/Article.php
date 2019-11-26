<?php

namespace Dewsign\NovaBlog\Models;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Maxfactor\Support\Webpage\Model;
use Illuminate\Support\Facades\Route;
use Dewsign\LaravelAuthors\Traits\HasAuthors;
use Maxfactor\Support\Webpage\Traits\HasSlug;
use Maxfactor\Support\Model\Traits\CanBeFeatured;
use Maxfactor\Support\Model\Traits\HasActiveState;
use Maxfactor\Support\Webpage\Traits\HasMetaAttributes;
use Maxfactor\Support\Webpage\Traits\MustHaveCanonical;
use Dewsign\NovaRepeaterBlocks\Traits\HasRepeaterBlocks;

class Article extends Model
{
    use HasSlug;
    use HasAuthors;
    use CanBeFeatured;
    use HasActiveState;
    use HasMetaAttributes;
    use HasRepeaterBlocks;
    use MustHaveCanonical;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    protected $table = 'blog_articles';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'published_date',
    ];

    /**
     * Get an article's categories.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(config('novablog.models.category', Category::class), 'blog_article_blog_category')
            ->ordered();
    }

    /**
     * Return the first category to be used as the primary category (e.g. for canonical url)
     *
     * @return Collection
     */
    public function getPrimaryCategoryAttribute()
    {
        return $this->categories->first();
    }

    /**
     * Only return articles that have been published.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished($query)
    {
        return $query->where('published_date', '<=', Carbon::now());
    }

    /**
     * Add required items to the breadcrumb seed
     *
     * @return array
     */
    public function seeds()
    {
        $category = Category::whereSlug(Route::input('category'))->first();

        return array_merge(parent::seeds(), [
            [
                'name' => __('Blog'),
                'url' => route('blog.index'),
            ],
            [
                'name' => Arr::get($category ?? $this->primaryCategory, 'navTitle'),
                'url' => route('blog.list', [$category ?? $this->primaryCategory]),
            ],
            [
                'name' => $this->navTitle,
                'url' => route('blog.show', [$category ?? $this->primaryCategory, $this]),
            ],
        ]);
    }

    public function baseCanonical()
    {
        return route('blog.show', [$this->primaryCategory, $this]);
    }
}
