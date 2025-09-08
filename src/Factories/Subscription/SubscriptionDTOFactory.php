<?php

namespace Denison\AsaasPackage\Factories\Subscription;

use Denison\AsaasPackage\DTO\Subscription\SubscriptionDTO;
use Denison\AsaasPackage\DTO\Subscription\SubscriptionUpdateDTO;

class SubscriptionDTOFactory
{
     /**
     * @param  array  $data
     * @param  string $type
     * @return SubscriptionDTO|SubscriptionUpdateDTO
     */
    public static function create(array $data, string $type)
    {
        if($type == 'create'){
            return SubscriptionDTO::create($data);
        }else{
            return SubscriptionUpdateDTO::create($data);
        }
    }
}