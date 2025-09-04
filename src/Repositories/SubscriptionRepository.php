<?php

namespace Denison\AsaasPackage\Repositories;

use Denison\AsaasPackage\Repositories\BaseRepository;
use Denison\AsaasPackage\Services\ResponseProcessor;

class SubscriptionRepository extends BaseRepository
{
    protected $responseProcessor;

    public function __construct($connection, ResponseProcessor $responseProcessor)
    {
        parent::__construct($connection, $responseProcessor);
    }
}