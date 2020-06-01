<?php

namespace Scuti\Admin\RepositoryRegenator;

use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/command' => base_path('app/Console/Command/'),
            __DIR__.'/stubs' => base_path('resources/stubs/'),
        ], "repositiry-generator");
    }
}