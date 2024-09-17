<?php

namespace Denison\AsaasPackage;

use Denison\AsaasPackage\Services\Client;

class Asaas
{
    protected $connection;

    public function __construct()
    {
        $this->connection = new Connection();
    }

    public function Cliente()
    {
        return new Client($this->connection);
    }
}