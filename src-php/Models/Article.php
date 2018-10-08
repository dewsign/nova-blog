<?php

namespace Dewsign\NovaBlog\Models;

use Maxfactor\Support\Webpage\Model;
use Maxfactor\Support\Webpage\Traits\HasSlug;
use Maxfactor\Support\Model\Traits\CanBeFeatured;
use Maxfactor\Support\Model\Traits\HasActiveState;
use Maxfactor\Support\Webpage\Traits\HasMetaAttributes;
use Dewsign\NovaRepeaterBlocks\Traits\HasRepeaterBlocks;

class Article extends Model
{
    use HasSlug;
    use CanBeFeatured;
    use HasActiveState;
    use HasMetaAttributes;
    use HasRepeaterBlocks;

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
        return $this->belongsToMany(Category::class, 'blog_article_blog_category')->ordered();
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

    public function getFeaturedImageLargeAttribute()
    {
        if (!$this->image) {
            return null;
        }

        return cloudinary_image($this->image, [
            "width" => 800,
            "height" => 450,
            "crop" => "fill",
            "gravity" => "auto",
            "fetch_format" => "auto",
        ]);
    }

    /**
     * Add required items to the breadcrumb seed
     *
     * @return array
     */
    public function seeds()
    {
        return array_merge(parent::seeds(), [
            [
                'name' => __('Blog'),
                'url' => route('blog.index'),
            ],
            [
                'name' => $this->primaryCategory->navTitle,
                'url' => route('blog.list', [$this->primaryCategory]),
            ],
            [
                'name' => $this->navTitle,
                'url' => route('blog.show', [$this->primaryCategory, $this]),
            ],
        ]);
    }
}
