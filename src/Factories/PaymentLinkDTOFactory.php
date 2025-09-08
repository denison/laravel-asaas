<?php

namespace Denison\AsaasPackage\Factories;

use Denison\AsaasPackage\DTO\PaymentLink\PaymentLinkDTO;
use Denison\AsaasPackage\DTO\PaymentLink\PaymentLinkUpdateDTO;

class PaymentLinkDTOFactory
{
    /**
     * @param  array  $data
     * @param  string $type
     * @return PaymentLinkDTO|PaymentLinkUpdateDTO
     */
    public static function create(array $data, string $type)
    {
        if($type == 'create'){
            return PaymentLinkDTO::create($data);
        }else{
            return PaymentLinkUpdateDTO::create($data);
        }
    }
}