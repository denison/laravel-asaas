<?php

namespace Denison\AsaasPackage\Factories\Payment;

use Denison\AsaasPackage\Contracts\PaymentInterface;
use Denison\AsaasPackage\Repositories\PaymentRepository;
use Denison\AsaasPackage\Services\Payment;
use Denison\AsaasPackage\Services\ResponseProcessor;

class PaymentFactory
{
    public static function create($connection): PaymentInterface
    {
        $process = new ResponseProcessor();
        $paymentRepo = new PaymentRepository($connection, $process);
        return new Payment($connection, $paymentRepo);
    }
}