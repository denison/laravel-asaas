<?php

namespace Denison\AsaasPackage\Repositories;

use Denison\AsaasPackage\Exceptions\ApiException;
use Denison\AsaasPackage\Exceptions\ConnectionException;
use Denison\AsaasPackage\Repositories\Base\RepositoryInterface;
use Denison\AsaasPackage\Services\ResponseProcessor;

abstract class BaseRepository implements RepositoryInterface
{
    protected $connection;
    protected $responseProcessor;

    public function __construct($connection, ResponseProcessor $responseProcessor)
    {
        $this->connection = $connection;
        $this->responseProcessor = $responseProcessor;
    }

    public function getAll(string $endpoint): ?array
    {
        try{
            $response = $this->connection->get($endpoint);
            return $this->responseProcessor->process($response);
        }catch (ConnectionException $e) {
            throw new ConnectionException('Erro ao conectar com a API.', 0, $e);
        } catch (ApiException $e) {
            throw new ApiException('Erro retornado pela API.', 0, $e);
        }
        
    }

    public function find(string $endpoint): ?array
    {
        try{
            $response = $this->connection->get($endpoint);
            return $this->responseProcessor->process($response);
        }catch (ConnectionException $e) {
            throw new ConnectionException('Erro ao conectar com a API.', 0, $e);
        } catch (ApiException $e) {
            throw new ApiException('Erro retornado pela API.', 0, $e);
        }
    }

    public function create(string $endpoint, array $data = [], array $headers = []): ?array
    {
        try{
            $response = $this->connection->post($endpoint, $data, $headers);
            return $this->responseProcessor->process($response);
        }catch (ConnectionException $e) {
            throw new ConnectionException('Erro ao conectar com a API.', 0, $e);
        } catch (ApiException $e) {
            throw new ApiException('Erro retornado pela API.', 0, $e);
        }
    }

    public function update(string $endpoint, array $data = [], $headers = []): ?array
    {
        try{
            $response = $this->connection->put($endpoint, $data, $headers);
            return $this->responseProcessor->process($response);
        }catch (ConnectionException $e) {
            throw new ConnectionException('Erro ao conectar com a API.', 0, $e);
        } catch (ApiException $e) {
            throw new ApiException('Erro retornado pela API.', 0, $e);
        }
    }
}