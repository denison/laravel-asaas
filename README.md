# Asaas Package

Pacote simples de pagamento para Laravel usando o Asaas.

## Instalação

```bash
composer require denison/asaas-package

## Configuração
```app.php

'providers' => [
    // Outros providers
    Denison\AsaasPackage\AsaasServiceProvider::class,
],

```bash
php artisan vendor:publish --provider="Denison\AsaasPackage\AsaasServiceProvider"


Para usar o pacote, você precisa definir as seguintes variáveis de ambiente em seu arquivo `.env`:

### Produção
```env
APP_ENV=production
ASAAS_API_URL=https://www.asaas.com/api/v3
ASAAS_API_KEY_PRODUCTION=api_produção

### DEV
```env
ASAAS_API_URL_SANDBOX=https://sandbox.asaas.com/api/v3
ASAAS_API_KEY_SANDBOX=api_sandbox


##Instânciar o Asaas
$asaas = new Asaas();

##Pegar todos CLientes
$customers = $asaas->Cliente()->getAll();


## Exceções

### `Denison\AsaasPackage\Exceptions\ConnectionException`

Lançada quando há um erro na conexão com a API. 

### `Denison\AsaasPackage\Exceptions\ApiException`

Lançada quando a API retorna um erro.

### `Denison\AsaasPackage\Exceptions\ClientException`

Lançada para erros específicos do cliente.

### Como Lidar com Exceções

Você deve capturar essas exceções em seu código e tratá-las conforme necessário.

```php
try {
    $customers = $asaas->Cliente()->getAll();
} catch (\Denison\AsaasPackage\Exceptions\ConnectionException $e) {
    // Tratar erro de conexão
} catch (\Denison\AsaasPackage\Exceptions\ApiException $e) {
    // Tratar erro da API
} catch (\Denison\AsaasPackage\Exceptions\ClientException $e) {
    // Tratar erro do cliente
}