<?php

namespace Scuti\Admin\RepositoryGenerator;

use Illuminate\Support\ServiceProvider;
use Scuti\Admin\RepositoryGenerator\Commands\RepositoryGenerator;

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
        if ($this->app->runningInConsole()) {
            $this->commands([
                RepositoryGenerator::class
            ]);
        }
    }
}