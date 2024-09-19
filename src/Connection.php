<?php

namespace Denison\AsaasPackage;

use Denison\AsaasPackage\Exceptions\ApiException;
use Denison\AsaasPackage\Exceptions\ConnectionException;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;

class Connection
{
    protected $client;
    protected $apiKey;
    protected $baseUri;

    public function __construct($baseUri, $apiKey)
    {
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
        try{
            $response = $this->client->request('GET', $endpoint);
            return $response;
        }catch(RequestException $e){
            if ($e->getResponse()) {
                throw new ApiException($e->getResponse()->getReasonPhrase(), $e->getCode(), $e);
            } else {
                throw new ConnectionException($e->getMessage(), $e->getCode(), $e);
            }
        }
    }

    public function post($endpoint, $data = [], $headers = [])
    {
        try{
            $response = $this->client->request('POST', $endpoint, [
                'body' => json_encode($data), // Codifica manualmente o JSON
                'headers' => array_merge([
                    'accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ], $headers), // Adiciona cabeçalhos adicionais
            ]);
            return $response;
        }catch(RequestException $e){
            if ($e->getResponse()) {
                throw new ApiException($e->getResponse()->getReasonPhrase(), $e->getCode(), $e);
            } else {
                throw new ConnectionException($e->getMessage(), $e->getCode(), $e);
            }
        }
    }

}