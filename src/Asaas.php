<?php

namespace Denison\AsaasPackage;

use Denison\AsaasPackage\Services\Cliente;

class Asaas
{
    protected $connection;

    public function __construct()
    {
        $this->connection = new Connection();
    }

    public function Cliente()
    {
        return new Cliente($this->connection);
    }
}