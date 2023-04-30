<?php

namespace Celysium\Request;

use Illuminate\Support\ServiceProvider;

class RequestBuilderServiceProvider extends ServiceProvider
{
    public function boot()
    {

        $this->publishes([
            __DIR__ . '/../config/request.php' => config_path('request.php'),
        ], 'request-config');
    }

    public function register()
    {
        $this->app->bind('request-builder', function($app) {
            return new RequestBuilder();
        });

        $this->mergeConfigFrom(
            __DIR__ . '/../config/request.php', 'request'
        );
    }
}
