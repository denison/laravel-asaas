<?php

namespace Denison\AsaasPackage;

use Denison\AsaasPackage\Factories\ConnectionFactory;
use Denison\AsaasPackage\Factories\CustomerFactory;

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

    public function getConnection()
    {
        return $this->connection;
    }
}