<?php

namespace Denison\AsaasPackage\Factories\Payment;

use Denison\AsaasPackage\Connection;
use Denison\AsaasPackage\Contracts\PaymentInterface;
use Denison\AsaasPackage\Repositories\PaymentRepository;
use Denison\AsaasPackage\Services\Payment;
use Denison\AsaasPackage\Services\ResponseProcessor;

class PaymentFactory
{
   /**
     * Cria uma instância de Payment, injetando um ResponseProcessor e um PaymentRepository
     * com base na conexão informada.
     *
     * @param Connection $connection Conexão HTTP já configurada para a API do Asaas.
     * @return PaymentInterface Instância pronta para uso do módulo de pagamentos.
     */
    public static function create($connection): PaymentInterface
    {
        $process = new ResponseProcessor();
        $paymentRepo = new PaymentRepository($connection, $process);
        return new Payment($connection, $paymentRepo);
    }
}