<?php

namespace Denison\AsaasPackage\Factories;

use Denison\AsaasPackage\Services\Customer;
use Denison\AsaasPackage\Contracts\CustomerInterface;
use Denison\AsaasPackage\Repositories\CustomerRepository;
use Denison\AsaasPackage\Services\ResponseProcessor;

class CustomerFactory
{
    public static function create($connection): CustomerInterface
    {
        $process = new ResponseProcessor();
        $customerRepo = new CustomerRepository($connection, $process);
        return new Customer($connection, $customerRepo);
    }
}