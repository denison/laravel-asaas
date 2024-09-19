<?php

namespace Denison\AsaasPackage\Repositories;

use Denison\AsaasPackage\Repositories\BaseRepository;
use Denison\AsaasPackage\Services\ResponseProcessor;

class CustomerRepository extends BaseRepository
{
    
    public function __construct($connection, ResponseProcessor $responseProcessor)
    {
        parent::__construct($connection, $responseProcessor);
    }

    // public function getCustomerByEmail($email)
    // {
    //     return $this->client->get("endpoint?email={$email}");
    // }
}