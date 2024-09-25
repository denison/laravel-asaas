<?php

namespace Denison\AsaasPackage\Services;

use Denison\AsaasPackage\Connection;
use Denison\AsaasPackage\Contracts\PaymentInterface;
use Denison\AsaasPackage\Factories\Payment\PaymentDTOFactory;
use Denison\AsaasPackage\Repositories\PaymentRepository;

class Payment implements PaymentInterface
{

    protected $connection;
    protected $paymentRepository;

    public function __construct(Connection $connection, PaymentRepository $paymentRepository)
    {
        $this->connection = $connection;
        $this->paymentRepository = $paymentRepository;
    }

    public function create(array $data): ?array
    {
        $paymentDTO = PaymentDTOFactory::create($data,'create');
        
        $endpoint = "payments";
        $headers = [
            'accept' => 'application/json',
        ];

        return $this->paymentRepository->create($endpoint, $paymentDTO->toArray(), $headers);
    }
}