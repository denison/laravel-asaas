<?php

namespace Denison\AsaasPackage\Services;

use Denison\AsaasPackage\Contracts\SubscriptionInterface;
use Denison\AsaasPackage\DTO\Subscription\SubscriptionUpdateDTO;
use Denison\AsaasPackage\Exceptions\ApiException;
use Denison\AsaasPackage\Factories\PaymentLinkDTOFactory;
use Denison\AsaasPackage\Factories\Subscription\SubscriptionDTOFactory;
use Denison\AsaasPackage\Repositories\SubscriptionRepository;
use InvalidArgumentException;

/**
 * Serviço para manipulação de Assinaturas no Asaas.
 * Implementa SubscriptionInterface e delega operações ao SubscriptionRepository.
 */
class Subscription implements SubscriptionInterface
{
    /**
     * @var mixed Conexão HTTP (classe Connection)
     */
    protected $connection;

    /**
     * @var SubscriptionRepository
     */
    protected $repository;

    public function __construct($connection, SubscriptionRepository $repository)
    {
        $this->connection = $connection;
        $this->repository = $repository;
    }

    /**
     * Lista assinaturas com filtros opcionais.
     *
     * @param array $filters
     * @return array
     */
    public function getAll(): array
    {
        return $this->repository->getAll('subscriptions');
    }

    /**
     * Retorna uma assinatura pelo ID.
     *
     * @param string $id
     * @return array
     */
    public function getById(string $id): array
    {
        return $this->repository->find("subscriptions/{$id}");
    }

    /**
     * Cria uma nova assinatura.
     *
     * @param array $data
     * @return array
     */
    public function create(array $data): array
    {
        try {
            $subscriptionDTO = SubscriptionDTOFactory::create($data, 'create'); // <-- pode lançar InvalidArgumentException
        } catch (InvalidArgumentException $e) {
            // ✅ converte para ApiException para o teste esperar a exceção correta
            throw new ApiException($e->getMessage(), 400, $e);
        }

        $endpoint = 'subscriptions';
        $headers = [
            'accept' => 'application/json',
        ];
        
        return $this->repository->create($endpoint, $subscriptionDTO->toArray(), $headers);
    }

    /**
     * Atualiza parcialmente uma assinatura.
     *
     * @param string $id
     * @param array $data
     * @return array
     */
    public function update(string $id, array $data): array
    {
        try {
            $subscriptionDTO = SubscriptionUpdateDTO::create($data, 'update'); // <-- pode lançar InvalidArgumentException
        } catch (InvalidArgumentException $e) {
            // ✅ mantém contrato de erro da lib
            throw new ApiException($e->getMessage(), 400, $e);
        }
        

        $endpoint = "subscriptions/{$id}";
        $headers = [
            'accept' => 'application/json',
        ];
        
        return $this->repository->update($endpoint, $subscriptionDTO->toArray(), $headers);
    }
}
