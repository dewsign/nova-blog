<?php

namespace Dewsign\NovaBlog\Providers;

use Laravel\Nova\Nova;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\App;
use Dewsign\NovaBlog\Models\Article;
use Illuminate\Pagination\Paginator;
use Dewsign\NovaBlog\Models\Category;
use Illuminate\Support\ServiceProvider;
use Dewsign\NovaBlog\Nova\BlogRepeaters;
use Illuminate\Database\Eloquent\Relations\Relation;

class PackageServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $this->publishConfigs();
        $this->bootViews();
        $this->bootAssets();
        $this->bootCommands();
        $this->publishDatabaseFiles();
        $this->registerWebRoutes();
        $this->registerMorphMaps();
        $this->configurePagination();
        $this->loadTranslations();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        Nova::resources([
            BlogRepeaters::class,
        ]);

        $this->mergeConfigFrom(
            $this->getConfigsPath(),
            'novablog'
        );
    }

    /**
     * Publish configuration file.
     *
     * @return void
     */
    private function publishConfigs()
    {
        $this->publishes([
            $this->getConfigsPath() => config_path('novablog.php'),
        ], 'config');
    }

    /**
     * Get local package configuration path.
     *
     * @return string
     */
    private function getConfigsPath()
    {
        return __DIR__.'/../Config/novablog.php';
    }

    /**
     * Register the artisan packages' terminal commands
     *
     * @return void
     */
    private function bootCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                // MyCommand::class,
            ]);
        }
    }

    /**
     * Load custom views
     *
     * @return void
     */
    private function bootViews()
    {
        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'nova-blog');
        $this->publishes([
            __DIR__.'/../Resources/views' => resource_path('views/vendor/nova-blog'),
        ]);
    }

    /**
     * Define publishable assets
     *
     * @return void
     */
    private function bootAssets()
    {
        $this->publishes([
            __DIR__.'/../Resources/assets/js' => resource_path('assets/js/vendor/nova-blog'),
        ], 'js');
    }

    private function publishDatabaseFiles()
    {
        $this->loadMigrationsFrom(__DIR__.'/../Database/migrations');

        $this->loadFactories();

        $this->publishes([
            __DIR__ . '/../Database/factories' => base_path('database/factories')
        ], 'factories');

        $this->publishes([
            __DIR__ . '/../Database/migrations' => base_path('database/migrations')
        ], 'migrations');

        $this->publishes([
            __DIR__ . '/../Database/seeds' => base_path('database/seeds')
        ], 'seeds');
    }

    /**
     * Only load the factories in non-production ready environments
     *
     * @return void
     */
    public function loadFactories()
    {
        if (App::environment(['production', 'staging'])) {
            return;
        }

        $this->app->make('Illuminate\Database\Eloquent\Factory')->load(
            __DIR__ . '/../Database/factories'
        );
    }

    /**
     * Load Web Routes into the application
     *
     * @return void
     */
    private function registerWebRoutes()
    {
        $this->loadRoutesFrom(__DIR__.'/../Routes/web.php');
    }

    /**
     * Register the Mophmaps
     *
     * @return void
     */
    private function registerMorphmaps()
    {
        Relation::morphMap([
            'novablog.article' => config('novablog.models.article', Article::class),
            'novablog.category' => config('novablog.models.category', Category::class),
        ]);
    }

    /**
     * Set te default pagination to not use bootstrap markup
     *
     * @return void
     */
    private function configurePagination()
    {
        Paginator::defaultView('pagination::default');
    }

    private function loadTranslations()
    {
        $this->loadJSONTranslationsFrom(__DIR__.'/../Resources/lang', 'novablog');
    }
}
