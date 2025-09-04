<?php

namespace Denison\AsaasPackage\Factories\PaymentLink;

use Denison\AsaasPackage\Contracts\PaymentLinkInterface;
use Denison\AsaasPackage\Repositories\PaymentLinkRepository;
use Denison\AsaasPackage\Services\{
    PaymentLink,
    ResponseProcessor
};

class PaymentLinkFactory
{
    public static function create($connection): PaymentLinkInterface
    {
        $process = new ResponseProcessor();
        $paymentLinkRepo = new PaymentLinkRepository($connection, $process);
        return new PaymentLink($connection, $paymentLinkRepo);
    }
}