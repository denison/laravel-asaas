<?php

namespace Denison\AsaasPackage;

use Denison\AsaasPackage\Factories\ConnectionFactory;
use Denison\AsaasPackage\Factories\CustomerFactory;
use Denison\AsaasPackage\Factories\Payment\PaymentFactory;

class Asaas
{
    protected $connection;

    public function __construct()
    {
        $this->connection = ConnectionFactory::create();
    }

    public function Cliente()
    {
        return CustomerFactory::create($this->connection);
    }

    public function Pagamento()
    {
        return PaymentFactory::create($this->connection);
    }

    public function getConnection()
    {
        return $this->connection;
    }
}