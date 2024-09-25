<?php

namespace Denison\AsaasPackage\Factories\Payment;

use Denison\AsaasPackage\DTO\Payment\PaymentDTO;

class PaymentDTOFactory
{
    public static function create(array $data, string $type): PaymentDTO
    {
        if($type == 'create')
        {
            return PaymentDTO::create($data);
        }
    }
}