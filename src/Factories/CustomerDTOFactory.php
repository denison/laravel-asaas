<?php

namespace Denison\AsaasPackage\Factories;

use Denison\AsaasPackage\DTO\CustomerDTO;
use Denison\AsaasPackage\DTO\CustomerUpdateDTO;

class CustomerDTOFactory
{
    /**
     * @param  array  $data
     * @param  string $type
     * @return CustomerDTO|CustomerUpdateDTO
     */
    public static function create(array $data, string $type)
    {
        if($type == 'create'){
            return CustomerDTO::create($data);
        }else{
            return CustomerUpdateDTO::create($data);
        }
    }
}