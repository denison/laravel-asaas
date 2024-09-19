<?php

abstract class BaseRepository
{
    protected $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function getAll(string $endpoint)
    {
        $response = $this->connection->get($endpoint);
        return json_decode($response->getBody()->getContents(), true);
    }

    
    public function find($id)
    {
        
    }
}