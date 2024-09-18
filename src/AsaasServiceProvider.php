<?php

namespace Denison\AsaasPackage;

use Denison\AsaasPackage\Contracts\CustomerInterface;
use Denison\AsaasPackage\Factories\ConnectionFactory;
use Denison\AsaasPackage\Factories\CustomerFactory;
use Denison\AsaasPackage\Services\Customer;
use Illuminate\Support\ServiceProvider;

class AsaasServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Asaas::class, function ($app) {
            return new Asaas();
        });

        
        $this->app->singleton(CustomerInterface::class, function ($app) {
            $asaas = $app->make(Asaas::class);
            return CustomerFactory::create($asaas->getConnection());
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/asaas.php' => config_path('asaas.php'),
        ]);
    }
}