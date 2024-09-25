<?php

namespace Denison\AsaasPackage\Repositories;

use Denison\AsaasPackage\Services\ResponseProcessor;

class PaymentRepository extends BaseRepository
{
    protected $responseProcessor;

    public function __construct($connection, ResponseProcessor $responseProcessor)
    {
        parent::__construct($connection, $responseProcessor);
    }
}