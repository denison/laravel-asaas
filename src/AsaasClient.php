<?php

namespace Denison\AsaasPackage;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;

class AsaasClient
{
    protected $client;
    protected $apiKey;
    protected $baseUri;

    public function __construct()
    {

        // Verifica se estamos dentro do Laravel e obtém as variáveis de ambiente
        $appEnv = env('APP_ENV');
        $this->apiKey = $appEnv === 'production'
            ? env('ASAAS_API_KEY_PRODUCTION')
            : env('ASAAS_API_KEY_SANDBOX');


        // Define a base URI com base no ambiente
        $this->baseUri = $appEnv === 'production'
            ? 'https://www.asaas.com/api/v3/'
            : 'https://sandbox.asaas.com/api/v3/';

        $this->client = new GuzzleClient([
            'base_uri' => $this->baseUri,
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->apiKey,
            ]
        ]);
    }

    public function getClients()
    {
        try {
            $response = $this->client->get('customers');
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            echo "Request failed: " . $e->getMessage();
            return null;
        }
    }
}