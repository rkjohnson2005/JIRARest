<?php

namespace rkjohnson2005\JIRARest;

use Illuminate\Support\ServiceProvider;

class JIRARestServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        include __DIR__.'/routes.php';
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->make('rkjohnson2005\JIRARest\JIRARestController');
    }
}
