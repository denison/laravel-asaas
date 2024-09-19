<?php

namespace Denison\AsaasPackage\Repositories;

use BaseRepository;

class CustomerRepository extends BaseRepository
{
    
    public function __construct($connection)
    {
        parent::__construct($connection);
    }

    // public function getCustomerByEmail($email)
    // {
    //     return $this->client->get("endpoint?email={$email}");
    // }
}