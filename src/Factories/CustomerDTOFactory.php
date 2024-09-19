<?php

namespace Denison\AsaasPackage\Factories;

use Denison\AsaasPackage\DTO\CustomerDTO;
use Denison\AsaasPackage\DTO\CustomerUpdateDTO;

class CustomerDTOFactory
{
    public static function create(array $data, string $type):  CustomerDTO|CustomerUpdateDTO
    {
        if($type == 'create'){
            return CustomerDTO::create($data);
        }else{
            return CustomerUpdateDTO::create($data);
        }
    }
}