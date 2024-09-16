<?php

namespace Denison\AsaasPackage;

use Illuminate\Support\ServiceProvider;

class AsaasServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(AsaasClient::class, function ($app) {
            $apiKey = config('asaas.api_key');
            return new AsaasClient($apiKey);
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/asaas.php' => config_path('asaas.php'),
        ]);
    }
}