<?php

namespace Denison\AsaasPackage;
use GuzzleHttp\Client as GuzzleClient;

class Connection
{
    protected $client;
    protected $apiKey;
    protected $baseUri;

    public function __construct($baseUri, $apiKey)
    {

        // Verifica se estamos dentro do Laravel e obtém as variáveis de ambiente
        // $appEnv = env('APP_ENV');
        // $this->apiKey = $appEnv === 'production'
        //     ? env('ASAAS_API_KEY_PRODUCTION')
        //     : env('ASAAS_API_KEY_SANDBOX');


        // // Define a base URI com base no ambiente
        // $this->baseUri = $appEnv === 'production'
        //     ? 'https://www.asaas.com/api/v3/'
        //     : 'https://sandbox.asaas.com/api/v3/';

        // $this->client = new GuzzleClient([
        //     'base_uri' => $this->baseUri,
        //     'headers' => [
        //         'Content-Type' => 'application/json',
        //         'access_token' => $this->apiKey,
        //     ]
        // ]);
        $this->baseUri = $baseUri;
        $this->apiKey = $apiKey;

        $this->client = new GuzzleClient([
            'base_uri' => $this->baseUri,
            'headers' => [
                'Content-Type' => 'application/json',
                'access_token' => $this->apiKey,
            ]
        ]);
    }

    public function get($endpoint)
    {
        return $this->client->request('GET', $endpoint);
    }

}