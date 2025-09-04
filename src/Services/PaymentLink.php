<?php

namespace Denison\AsaasPackage\Services;

use Denison\AsaasPackage\Connection;
use Denison\AsaasPackage\Contracts\PaymentLinkInterface;
use Denison\AsaasPackage\Factories\PaymentLinkDTOFactory;
use Denison\AsaasPackage\Repositories\PaymentLinkRepository;

class PaymentLink implements PaymentLinkInterface
{
    protected $connection;
    protected $paymentLinkRepo;


    public function __construct(Connection $connection, PaymentLinkRepository $paymentLinkRepo)
    {
        $this->connection = $connection;
        $this->paymentLinkRepo = $paymentLinkRepo;
    }

    public function getAll(): ?array
    {
        return $this->paymentLinkRepo->getAll('paymentLinks');
    }

    public function getById($id): ?array
    {
        return $this->paymentLinkRepo->find("paymentLinks/{$id}");
    }

    public function create(array $data): ?array
    {
        // $customerDTO = CustomerDTO::create($data);
        $customerDTO = PaymentLinkDTOFactory::create($data,'create');

        $endpoint = 'paymentLinks';
        $headers = [
            'accept' => 'application/json',
        ];
        return $this->paymentLinkRepo->create($endpoint, $customerDTO->toArray(), $headers);
    }

    public function update(string $id, array $data = []): ?array
    {
        // $customerDTO = CustomerUpdateDTO::create($data);
        $customerDTO = PaymentLinkDTOFactory::create($data,'update');

        $endpoint = "paymentLinks/{$id}";
        $headers = [
            'accept' => 'application/json',
        ];
        
        return $this->paymentLinkRepo->update($endpoint, $customerDTO->toArray(), $headers);
    }
}