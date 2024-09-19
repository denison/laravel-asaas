<?php

namespace Denison\AsaasPackage\Services;

use Denison\AsaasPackage\Exceptions\ApiException;

class ResponseProcessor
{
    public function process($response): ?array
    {
        $data = json_decode($response->getBody()->getContents(), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new ApiException('Erro ao decodificar a resposta JSON.');
        }

        return $data;
    }
}