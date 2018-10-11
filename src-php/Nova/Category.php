<?php

namespace Dewsign\NovaBlog\Nova;

use Laravel\Nova\Resource;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\MorphMany;
use Naxon\NovaFieldSortable\Sortable;
use Benjaminhirsch\NovaSlugField\Slug;
use Laravel\Nova\Fields\BelongsToMany;
use Dewsign\NovaBlog\Nova\BlogRepeaters;
use Laravel\Nova\Http\Requests\NovaRequest;
use Benjaminhirsch\NovaSlugField\TextWithSlug;
use Maxfactor\Support\Webpage\Nova\MetaAttributes;
use Naxon\NovaFieldSortable\Concerns\SortsIndexEntries;
use Silvanite\NovaFieldCloudinary\Fields\CloudinaryImage;

class Category extends Resource
{
    use SortsIndexEntries;

    public static $defaultSortField = 'sort_order';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'Dewsign\NovaBlog\Models\Category';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'name',
        'slug',
    ];

    public static $group = 'Blog';

    public static function label()
    {
        return __('Categories');
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),
            Boolean::make('Active')->sortable()->rules('required', 'boolean'),
            Boolean::make('Featured')->sortable()->rules('required', 'boolean'),
            TextWithSlug::make('Name')->sortable()->rules('required_if:active,1', 'max:254')->slug('Slug'),
            Slug::make('Slug')->sortable()->rules('required', 'alpha_dash', 'max:254'),
            CloudinaryImage::make('Image'),
            Sortable::make('Sort Order', 'id'),
            HasMany::make('Articles'),
            MorphMany::make(__('Repeaters'), 'repeaters', BlogRepeaters::class),
            MetaAttributes::make(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
