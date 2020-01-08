<?php

namespace Dewsign\NovaBlog\Nova;

use Laravel\Nova\Resource;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\MorphMany;
use Benjaminhirsch\NovaSlugField\Slug;
use Laravel\Nova\Fields\BelongsToMany;
use Dewsign\NovaFieldSortable\IsSorted;
use Dewsign\NovaFieldSortable\Sortable;
use Dewsign\NovaBlog\Nova\BlogRepeaters;
use Laravel\Nova\Http\Requests\NovaRequest;
use Benjaminhirsch\NovaSlugField\TextWithSlug;
use Maxfactor\Support\Webpage\Nova\MetaAttributes;

class Category extends Resource
{
    use IsSorted;

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

    /**
     * Get the logical group associated with the resource.
     *
     * @return string
     */
    public static function group()
    {
        return config('novablog.group', static::$group);
    }

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
            Sortable::make('Sort', 'id'),
            ID::make(),
            Boolean::make('Active')->rules('required', 'boolean'),
            Boolean::make('Featured')->rules('required', 'boolean'),
            TextWithSlug::make('Name')->rules('required_if:active,1', 'max:254')->slug('slug'),
            Slug::make('Slug')->rules('required', 'alpha_dash', 'max:254'),
            config('novablog.images.field')::make('Image')->disk(config('novablog.images.disk', 'public')),
            Text::make('Alternative Text')->rules('nullable', 'max:254')->hideFromIndex(),
            HasMany::make('Articles', 'articles', config('novablog.resources.article', Article::class)),
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
