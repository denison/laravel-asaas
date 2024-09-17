<?php

namespace Denison\AsaasPackage\Services;

use Denison\AsaasPackage\Connection;

class Client
{
    protected $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getAll()
    {
        $response = $this->connection->get('customers');
        return json_decode($response->getBody()->getContents(), true);
    }

    public function getById($id)
    {
        $response = $this->connection->get("customers/{$id}");
        return json_decode($response->getBody()->getContents(), true);
    }
}