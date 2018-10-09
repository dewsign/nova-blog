<?php

namespace Dewsign\NovaBlog\Models;

use Maxfactor\Support\Webpage\Model;
use Spatie\EloquentSortable\Sortable;
use Maxfactor\Support\Webpage\Traits\HasSlug;
use Maxfactor\Support\Model\Traits\HasSortOrder;
use Maxfactor\Support\Model\Traits\CanBeFeatured;
use Maxfactor\Support\Model\Traits\HasActiveState;
use Maxfactor\Support\Webpage\Traits\HasMetaAttributes;
use Maxfactor\Support\Webpage\Traits\MustHaveCanonical;
use Dewsign\NovaRepeaterBlocks\Traits\HasRepeaterBlocks;

class Category extends Model implements Sortable
{
    use HasSlug;
    use HasSortOrder;
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

    protected $table = 'blog_categories';

    /**
     * Get a category's articles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function articles()
    {
        return $this->belongsToMany(Article::class, 'blog_article_blog_category');
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
                'name' => $this->navTitle,
                'url' => route('blog.list', [$this]),
            ],
        ]);
    }
}
