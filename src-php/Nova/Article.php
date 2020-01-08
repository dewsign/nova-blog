<?php

namespace Dewsign\NovaBlog\Nova;

use Laravel\Nova\Resource;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\MorphMany;
use Dewsign\NovaBlog\Nova\Category;
use Laravel\Nova\Fields\MorphToMany;
use Benjaminhirsch\NovaSlugField\Slug;
use Laravel\Nova\Fields\BelongsToMany;
use Dewsign\NovaBlog\Nova\BlogRepeaters;
use Benjaminhirsch\NovaSlugField\TextWithSlug;
use Maxfactor\Support\Webpage\Nova\MetaAttributes;

class Article extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'Dewsign\NovaBlog\Models\Article';

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
        'summary',
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
        return __('Articles');
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
            Number::make('Priority')->sortable()->rules('required', 'integer'),
            TextWithSlug::make('Name')->sortable()->rules('required_if:active,1', 'max:254')->slug('slug'),
            Slug::make('Slug')->sortable()->rules('required', 'alpha_dash', 'max:254')->hideFromIndex(),
            DateTime::make('Published Date')->sortable()->hideFromIndex()->rules('required_if:active,1', 'date'),
            config('novablog.images.field')::make('Image')->disk(config('novablog.images.disk', 'public')),
            Text::make('Alternative Text')->rules('nullable', 'max:254')->hideFromIndex(),
            Textarea::make('Summary'),
            BelongsToMany::make('Categories', 'categories', config('novablog.resources.category', Category::class)),
            MorphToMany::make('Authors', 'authors', config('novablog.resources.author'))->searchable(),
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
