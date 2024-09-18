<?php

namespace Denison\AsaasPackage\Factories;

use Denison\AsaasPackage\Services\Customer;
use Denison\AsaasPackage\Contracts\CustomerInterface;

class CustomerFactory
{
    public static function create($connection): CustomerInterface
    {
        return new Customer($connection);
    }
}