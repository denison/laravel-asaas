<?php

namespace Denison\AsaasPackage\Services;

use Denison\AsaasPackage\Exceptions\ApiException;

class ResponseProcessor
{
   /**
     * Processa a resposta HTTP da API do Asaas e retorna um array associativo.
     *
     * @param \Psr\Http\Message\ResponseInterface $response Resposta HTTP da requisição.
     * @return array|null Dados decodificados ou null se a resposta estiver vazia.
     *
     * @throws \Denison\AsaasPackage\Exceptions\ApiException Se não conseguir decodificar o JSON.
     */
    public function process($response): ?array
    {
        $data = json_decode($response->getBody()->getContents(), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new ApiException('Erro ao decodificar a resposta JSON.');
        }

        return $data;
    }
}