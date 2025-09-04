<?php

namespace Denison\AsaasPackage\Factories;

use Denison\AsaasPackage\Connection;

class ConnectionFactory
{
    /**
     * Cria uma nova instância de Connection configurada para produção ou sandbox,
     * de acordo com a variável de ambiente APP_ENV.
     *
     * Ambiente:
     * - production → Usa ASAAS_API_KEY_PRODUCTION e URL oficial.
     * - qualquer outro valor → Usa ASAAS_API_KEY_SANDBOX e URL de sandbox.
     *
     * @return Connection Conexão HTTP para comunicação com a API do Asaas.
     */
    public static function create(): Connection
    {
        $appEnv = env('APP_ENV');
        $apiKey = $appEnv === 'production'
            ? env('ASAAS_API_KEY_PRODUCTION')
            : env('ASAAS_API_KEY_SANDBOX');

        $baseUri = $appEnv === 'production'
            ? 'https://www.asaas.com/api/v3/'
            : 'https://sandbox.asaas.com/api/v3/';

        return new Connection($baseUri, $apiKey);
    }
}