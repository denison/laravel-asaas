<?php

namespace Denison\AsaasPackage;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;

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