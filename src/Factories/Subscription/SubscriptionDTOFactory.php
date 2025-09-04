<?php

namespace Denison\AsaasPackage\Factories\Subscription;

use Denison\AsaasPackage\DTO\Subscription\SubscriptionDTO;
use Denison\AsaasPackage\DTO\Subscription\SubscriptionUpdateDTO;

class SubscriptionDTOFactory
{
    public static function create(array $data, string $type):  SubscriptionDTO|SubscriptionUpdateDTO
    {
        if($type == 'create'){
            return SubscriptionDTO::create($data);
        }else{
            return SubscriptionUpdateDTO::create($data);
        }
    }
}