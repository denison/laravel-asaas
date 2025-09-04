<?php

namespace Denison\AsaasPackage\Factories\Subscription;

use Denison\AsaasPackage\Contracts\SubscriptionInterface;
use Denison\AsaasPackage\Repositories\SubscriptionRepository;
use Denison\AsaasPackage\Services\ResponseProcessor;
use Denison\AsaasPackage\Services\Subscription;

/**
 * Factory responsável por criar o módulo de Assinaturas.
 */
class SubscriptionFactory
{
    /**
     * Cria uma instância de Subscription, injetando um ResponseProcessor e
     * um SubscriptionRepository com base na conexão informada.
     *
     * @param mixed $connection Conexão HTTP já configurada para a API do Asaas.
     * @return SubscriptionInterface Instância pronta para uso do módulo de assinaturas.
     */
    public static function create($connection): SubscriptionInterface
    {
        $processor   = new ResponseProcessor();
        $repository  = new SubscriptionRepository($connection, $processor);

        return new Subscription($connection, $repository);
    }
}
