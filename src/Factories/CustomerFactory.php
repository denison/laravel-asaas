<?php

namespace Denison\AsaasPackage\Factories;

use Denison\AsaasPackage\Services\Customer;
use Denison\AsaasPackage\Contracts\CustomerInterface;
use Denison\AsaasPackage\Repositories\CustomerRepository;

class CustomerFactory
{
    public static function create($connection): CustomerInterface
    {
        $customerRepo = new CustomerRepository($connection);
        return new Customer($connection, $customerRepo);
    }
}