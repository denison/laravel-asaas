<?php

namespace Denison\AsaasPackage;

use Denison\AsaasPackage\Exceptions\ApiException;
use Denison\AsaasPackage\Exceptions\ConnectionException;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Response;

/**
 * Responsável por gerenciar a comunicação HTTP com a API do Asaas,
 * encapsulando as requisições GET, POST e PUT.
 */
class Connection
{
     /**
     * Cliente HTTP do Guzzle configurado para a API do Asaas.
     *
     * @var GuzzleClient
     */
    protected $client;

      /**
     * Chave de autenticação da API.
     *
     * @var string
     */
    protected $apiKey;

    /**
     * URL base da API.
     *
     * @var string
     */
    protected $baseUri;

    /**
     * Inicializa a conexão com a API configurando o cliente HTTP.
     *
     * @param string $baseUri URL base da API (produção ou sandbox).
     * @param string $apiKey  Chave de autenticação (token Asaas).
     */
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

    /**
     * Envia uma requisição GET para a API.
     *
     * @param string $endpoint Caminho relativo ao recurso na API.
     * @return Response Resposta bruta da API.
     *
     * @throws ApiException        Caso a API retorne erro.
     * @throws ConnectionException Caso não seja possível conectar.
     */
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

     /**
     * Envia uma requisição POST para a API.
     *
     * @param string $endpoint Caminho relativo ao recurso na API.
     * @param array  $data     Dados para envio no corpo da requisição.
     * @param array  $headers  Cabeçalhos adicionais (opcional).
     * @return Response Resposta bruta da API.
     *
     * @throws ApiException        Caso a API retorne erro.
     * @throws ConnectionException Caso não seja possível conectar.
     */
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

     /**
     * Envia uma requisição PUT para a API.
     *
     * @param string $endpoint Caminho relativo ao recurso na API.
     * @param array  $data     Dados para envio no corpo da requisição (opcional).
     * @param array  $headers  Cabeçalhos adicionais (opcional).
     * @return Response Resposta bruta da API.
     *
     * @throws ApiException        Caso a API retorne erro.
     * @throws ConnectionException Caso não seja possível conectar.
     */
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