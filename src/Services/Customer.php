<?php

namespace Denison\AsaasPackage\Services;

use Denison\AsaasPackage\Connection;
use Denison\AsaasPackage\Contracts\CustomerInterface;
use Denison\AsaasPackage\DTO\CustomerDTO;
use Denison\AsaasPackage\Exceptions\ApiException;
use Denison\AsaasPackage\Exceptions\ConnectionException;
use Denison\AsaasPackage\Repositories\CustomerRepository;

class Customer implements CustomerInterface
{
    protected $connection;
    protected $customerRepo;

    public function __construct(Connection $connection, CustomerRepository $customerRepo)
    {
        $this->connection = $connection;
        $this->customerRepo = $customerRepo;
    }

    public function getAll(): ?array
    {
        return $this->customerRepo->getAll('customers');
    }

    public function getById($id): ?array
    {
        return $this->customerRepo->find("customers/{$id}");
    }

    public function create(array $data): ?array
    {
        $customerDTO = CustomerDTO::create($data);

        $endpoint = 'customers';
        $headers = [
            'accept' => 'application/json',
        ];
        return $this->customerRepo->create($endpoint, $customerDTO->toArray(), $headers);
    }
}