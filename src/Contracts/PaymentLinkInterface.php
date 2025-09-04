<?php

namespace Denison\AsaasPackage\Contracts;

interface PaymentLinkInterface
{
    /**
     * Lista links de pagamento .
     *
     * 
     * @return array|null
     */
    public function getAll(): ?array;

    /**
     * Obtém um link de pagamento pelo ID.
     *
     * @param string $id
     * @return array|null
     */
    public function getById(string $id): ?array;

    /**
     * Cria um link/checkout pronto no Asaas.
     *
     * Campos comuns (exemplos): 
     *  - name (string)
     *  - billingType (string|array) ex.: 'CREDIT_CARD' | 'PIX' | 'BOLETO' ou ['PIX','CREDIT_CARD']
     *  - chargeType (string) ex.: 'DETACHED' (avulso) | 'RECURRENT' (recorrente)
     *  - value (float) | totalValue (float) conforme o caso
     *  - dueDateLimitDays (int)
     *  - description (string)
     *  - maxInstallmentCount (int) (opcional)
     *  - redirectUrl / callbackUrl (string) (opcionais)
     *
     * @param array $data
     * @return array|null
     */
    public function create(array $data): ?array;

    /**
     * Atualiza um link de pagamento existente.
     *
     * @param string $id
     * @param array $data
     * @return array|null
     */
    public function update(string $id, array $data = []): ?array;
}
