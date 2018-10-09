<?php

namespace Dewsign\NovaBlog\Providers;

use Dewsign\NovaBlog\Models\Article;
use Illuminate\Support\Facades\Gate;
use Dewsign\NovaBlog\Models\Category;
use Dewsign\NovaBlog\Policies\BlogPolicy;
use Silvanite\Brandenburg\Traits\ValidatesPermissions;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    use ValidatesPermissions;

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Article::class => BlogPolicy::class,
        Category::class => BlogPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        collect([
            'viewBlog',
            'manageBlog',
        ])->each(function ($permission) {
            Gate::define($permission, function ($user) use ($permission) {
                if ($this->nobodyHasAccess($permission)) {
                    return true;
                }

                return $user->hasRoleWithPermission($permission);
            });
        });

        $this->registerPolicies();
    }
}
