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
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        include __DIR__.'/routes.php';
        $this->app->make('rkjohnson2005\JIRARest\JIRARestController');
    }
}
