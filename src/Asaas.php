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

/**
 *
 * Centraliza a conexão com a API e expõe os módulos via Factories,
 * garantindo que todos compartilhem a mesma conexão.
 */
class Asaas
{
    /**
     * Conexão HTTP criada por ConnectionFactory::create().
     *
     * @var mixed
     */

    protected $connection;

     /**
     * Cria a conexão compartilhada que será usada por todos os módulos.
     */
    public function __construct()
    {
        $this->connection = ConnectionFactory::create();
    }

    /**
     * Retorna o módulo de Clientes (instanciado pela CustomerFactory). Usado para pegar os customers do asaas
     * utilizando a conexão compartilhada.
     *
     * @return CustomerInterface
     */
    public function Cliente(): CustomerInterface
    {
        return CustomerFactory::create($this->connection);
    }

     /**
     * Retorna o módulo de Pagamentos (instanciado pela PaymentFactory). Usado para pegar pagamentos
     * utilizando a conexão compartilhada.
     *
     * @return PaymentInterface
     */
    public function Pagamento(): PaymentInterface
    {
        return PaymentFactory::create($this->connection);
    }

    /**
     * Retorna o módulo de Link de Pagamento (instanciado pela PaymentLinkFactory)
     * utilizando a conexão compartilhada.
     *
     * @return PaymentLinkInterface
     */
    public function PagamentoLink(): PaymentLinkInterface
    {
        return PaymentLinkFactory::create($this->connection);
    }


    /**
     * Retorna o módulo de Assinaturas (instanciado pela SubscriptionFactory).
     * Usado para criar e gerenciar assinaturas no Asaas utilizando a conexão compartilhada.
     *
     * @return SubscriptionInterface
     */
    public function Assinatura(): SubscriptionInterface
    {
        return SubscriptionFactory::create($this->connection);
    }

   /**
     * Expõe a conexão compartilhada para uso em bindings do Service Provider
     * ou em módulos adicionais que sigam o mesmo padrão de Factory.
     *
     * @return Connection
     */
    public function getConnection()
    {
        return $this->connection;
    }
}