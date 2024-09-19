<?php

namespace Denison\AsaasPackage\Services;

use Denison\AsaasPackage\Connection;
use Denison\AsaasPackage\Contracts\CustomerInterface;
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

    public function getAll()
    {
        try{
            return $this->customerRepo->getAll('customers');
        }catch (ConnectionException $e) {
            throw new ConnectionException('Erro ao conectar com a API.', 0, $e);
        } catch (ApiException $e) {
            throw new ApiException('Erro retornado pela API.', 0, $e);
        }
    }

    public function getById($id)
    {
        try{
            $response = $this->connection->get("customers/{$id}");
            return json_decode($response->getBody()->getContents(), true);
        }catch (ConnectionException $e) {
            // Lidar com erros de conexão
            throw new ConnectionException('Erro ao conectar com a API.', 0, $e);
        } catch (ApiException $e) {
            // Lidar com erros da API
            throw new ApiException('Erro retornado pela API.', 0, $e);
        }
    }
}