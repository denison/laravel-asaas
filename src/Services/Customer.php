<?php

namespace Denison\AsaasPackage\Services;

use Denison\AsaasPackage\Connection;
use Denison\AsaasPackage\Contracts\CustomerInterface;
use Denison\AsaasPackage\Exceptions\ApiException;
use Denison\AsaasPackage\Exceptions\ConnectionException;
use Denison\AsaasPackage\Factories\ClientFactory;
use Denison\AsaasPackage\Factories\ConnectionFactory;

class Customer implements CustomerInterface
{
    protected $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getAll()
    {
        try{
            $response = $this->connection->get('customers');
            return json_decode($response->getBody()->getContents(), true);
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