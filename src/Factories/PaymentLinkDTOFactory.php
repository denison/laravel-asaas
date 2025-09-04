<?php

namespace Denison\AsaasPackage\Factories;

use Denison\AsaasPackage\DTO\PaymentLink\PaymentLinkDTO;
use Denison\AsaasPackage\DTO\PaymentLink\PaymentLinkUpdateDTO;

class PaymentLinkDTOFactory
{
    public static function create(array $data, string $type):  PaymentLinkDTO|PaymentLinkUpdateDTO
    {
        if($type == 'create'){
            return PaymentLinkDTO::create($data);
        }else{
            return PaymentLinkUpdateDTO::create($data);
        }
    }
}