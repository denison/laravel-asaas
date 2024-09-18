<?php

namespace Denison\AsaasPackage\Factories;

use Denison\AsaasPackage\Connection;

class ConnectionFactory
{
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