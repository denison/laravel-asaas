<?php

namespace Denison\AsaasPackage;

use Denison\AsaasPackage\Contracts\ClientInterface;
use Denison\AsaasPackage\Services\Client;
use Illuminate\Support\ServiceProvider;

class AsaasServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Asaas::class, function ($app) {
            return new Asaas();
        });

        $this->app->singleton(ClientInterface::class, function ($app) {
            return new Client(new Connection());
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/asaas.php' => config_path('asaas.php'),
        ]);
    }
}