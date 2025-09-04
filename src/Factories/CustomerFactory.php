<?php

namespace Denison\AsaasPackage\Factories;

use Denison\AsaasPackage\Services\Customer;
use Denison\AsaasPackage\Contracts\CustomerInterface;
use Denison\AsaasPackage\Repositories\CustomerRepository;
use Denison\AsaasPackage\Services\ResponseProcessor;

/**
 * Factory responsável por criar o módulo de Clientes.
 * Sempre injeta a mesma conexão compartilhada e um ResponseProcessor
 * para processamento uniforme das respostas da API.
 */
class CustomerFactory
{
    /**
     * Cria a implementação de CustomerInterface.
     *
     * @param mixed $connection Conexão HTTP criada pelo ConnectionFactory.
     */
    public static function create($connection): CustomerInterface
    {
        $process = new ResponseProcessor();
        $customerRepo = new CustomerRepository($connection, $process);
        return new Customer($connection, $customerRepo);
    }
}