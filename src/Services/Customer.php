<?php

namespace Denison\AsaasPackage\Services;

use Denison\AsaasPackage\Connection;
use Denison\AsaasPackage\Contracts\CustomerInterface;
use Denison\AsaasPackage\DTO\CustomerDTO;
use Denison\AsaasPackage\DTO\CustomerUpdateDTO;
use Denison\AsaasPackage\Exceptions\ApiException;
use Denison\AsaasPackage\Exceptions\ConnectionException;
use Denison\AsaasPackage\Factories\CustomerDTOFactory;
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

    public function getByCpfCnpj(string $cpfCnpj): ?array
    {
        $document = preg_replace('/\D+/', '', $cpfCnpj);

        if (empty($document)) {
            return null;
        }

        $response = $this->customerRepo->find('customers?cpfCnpj='.urlencode($document));
        $customers = $response['data'] ?? $response;

        if (! is_array($customers) || empty($customers)) {
            return null;
        }

        foreach ($customers as $customer) {
            if (! is_array($customer)) {
                continue;
            }

            $remoteDocument = preg_replace('/\D+/', '', (string) ($customer['cpfCnpj'] ?? ''));

            if ($remoteDocument === $document) {
                return $customer;
            }
        }

        return null;
    }

    public function create(array $data): ?array
    {
        // $customerDTO = CustomerDTO::create($data);
        $customerDTO = CustomerDTOFactory::create($data,'create');

        $endpoint = 'customers';
        $headers = [
            'accept' => 'application/json',
        ];
        return $this->customerRepo->create($endpoint, $customerDTO->toArray(), $headers);
    }

    public function update(string $id, array $data = []): ?array
    {
        // $customerDTO = CustomerUpdateDTO::create($data);
        $customerDTO = CustomerDTOFactory::create($data,'update');

        $endpoint = "customers/{$id}";
        $headers = [
            'accept' => 'application/json',
        ];
        
        return $this->customerRepo->update($endpoint, $customerDTO->toArray(), $headers);
    }
}
