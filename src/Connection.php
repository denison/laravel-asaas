<?php

namespace Denison\AsaasPackage;

use Denison\AsaasPackage\Exceptions\ApiException;
use Denison\AsaasPackage\Exceptions\ConnectionException;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Response;

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

    public function get($endpoint): Response
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

    public function post($endpoint, $data = [], $headers = []): Response
    {
        try{
            $response = $this->client->request('POST', $endpoint, [
                'body' => json_encode($data),
                'headers' => array_merge([
                    'accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ], $headers),
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

    public function put($endpoint, $data = [], $headers = []): Response
    {
        try{
            $options = [
                'headers' => array_merge([
                    'accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ], $headers),
            ];
            
            if (!empty($data)) {
                $options['body'] = json_encode($data);
            }

            $response = $this->client->request('PUT', $endpoint, $options);
            
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