<?php

namespace Denison\AsaasPackage\Contracts;

/**
 * Contrato para operações de Assinatura (recorrência) no Asaas.
 *
 * Padrão adotado na biblioteca:
 * - getAll()   → lista assinaturas (com filtros opcionais)
 * - getById()  → busca uma assinatura por ID
 * - create()   → cria uma assinatura (mensal, anual, etc.)
 * - update()   → atualiza parcialmente uma assinatura
 */
interface SubscriptionInterface
{
    /**
     * Lista assinaturas com filtros opcionais (paginações, customer, status, etc.).
     *
     * @param array $filters
     * @return array
     */
    public function getAll(): ?array;

    /**
     * Obtém uma assinatura pelo ID.
     *
     * @param string $id
     * @return array
     */
    public function getById(string $id): ?array;

    /**
     * Cria uma nova assinatura (recorrente) para um cliente.
     * Ex.: cycle = MONTHLY | ANNUAL, billingType = BOLETO | PIX | CREDIT_CARD
     *
     * @param array $data
     * @return array
     */
    public function create(array $data): ?array;

    /**
     * Atualiza parcialmente os dados de uma assinatura.
     *
     * @param string $id
     * @param array  $data
     * @return array
     */
    public function update(string $id, array $data): ?array;
}
