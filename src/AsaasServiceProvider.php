<?php

namespace Denison\AsaasPackage;

use Denison\AsaasPackage\Contracts\CustomerInterface;
use Denison\AsaasPackage\Contracts\PaymentInterface;
use Denison\AsaasPackage\Contracts\PaymentLinkInterface;
use Denison\AsaasPackage\Contracts\SubscriptionInterface;
use Denison\AsaasPackage\Factories\ConnectionFactory;
use Denison\AsaasPackage\Factories\CustomerFactory;
use Denison\AsaasPackage\Factories\Payment\PaymentFactory;
use Denison\AsaasPackage\Factories\PaymentLink\PaymentLinkFactory;
use Denison\AsaasPackage\Factories\Subscription\SubscriptionFactory;
use Denison\AsaasPackage\Services\Customer;
use Illuminate\Support\ServiceProvider;

class AsaasServiceProvider extends ServiceProvider
{
    /**
     * Registra as dependências e singletons do pacote Asaas
    */
    public function register()
    {

        $this->app->singleton(Asaas::class, function ($app) {
            return new Asaas();
        });

        
        $this->app->singleton(CustomerInterface::class, function ($app) {
            $asaas = $app->make(Asaas::class);
            return CustomerFactory::create($asaas->getConnection());
        });

        // Pagamento
        $this->app->singleton(PaymentInterface::class, function ($app) {
            $asaas = $app->make(Asaas::class);
            return PaymentFactory::create($asaas->getConnection());
        });

         // PaymentLink
        $this->app->singleton(PaymentLinkInterface::class, function ($app) {
            $asaas = $app->make(Asaas::class);
            return PaymentLinkFactory::create($asaas->getConnection());
        });

        $this->app->singleton(SubscriptionInterface::class, function ($app) {
            $asaas = $app->make(Asaas::class);
            return SubscriptionFactory::create($asaas->getConnection());
        });
    }

     /**
     * Publica arquivos de configuração do pacote
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/asaas.php' => config_path('asaas.php'),
        ]);
    }
}