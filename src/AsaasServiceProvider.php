<?php

namespace Denison\AsaasPackage;

use Illuminate\Support\ServiceProvider;

class AsaasServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Asaas::class, function ($app) {
            return new Asaas();
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/asaas.php' => config_path('asaas.php'),
        ]);
    }
}