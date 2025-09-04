# Asaas Package

Pacote de integração simples com a API do [Asaas](https://asaas.com) para projetos em PHP/Laravel.

## Instalação

Para instalar a versão mais recente disponível:

```bash
composer require denison/asaas-package

## Atualização

Para atualizar o pacote para a versão mais recente dentro da faixa instalada 
Atenção: este pacote segue versionamento semântico (SemVer).

Atualizações de major (ex.: 1.x → 2.x) podem trazer mudanças incompatíveis.

Se você prefere estabilidade, instale fixando uma faixa de versão, como ^1.0.

Se você prefere sempre a versão mais nova, use o comando acima sem restrições.
```bash
composer update denison/asaas-package


## Configuração

No arquivo `config/app.php`, registre o service provider:

```php
'providers' => [
    // Outros providers
    Denison\AsaasPackage\AsaasServiceProvider::class,
],

```bash

Depois, publique as configurações do pacote:

php artisan vendor:publish --provider="Denison\AsaasPackage\AsaasServiceProvider"


Para usar o pacote, você precisa definir as seguintes variáveis de ambiente em seu arquivo `.env`:

### Produção
```env
APP_ENV=production
ASAAS_API_URL=https://www.asaas.com/api/v3
ASAAS_API_KEY_PRODUCTION=api_produção

### DEV
```env
APP_ENV=local
ASAAS_API_URL_SANDBOX=https://sandbox.asaas.com/api/v3
ASAAS_API_KEY_SANDBOX=api_sandbox


## Instanciar o Asaas

Para começar a usar, basta instanciar a classe principal:

```php
use Denison\AsaasPackage\Asaas;

$asaas = new Asaas();


## Clientes

Gerencie clientes diretamente pelo módulo `Cliente()`:

### Listar todos
```php
$customers = $asaas->Cliente()->getAll();

# Buscar por ID
```php
$customer = $asaas->Cliente()->getById($id);

### Criar novo cliente

```php
$customer = $asaas->Cliente()->create([
    'name'          => 'João da Silva',     // obrigatório
    'cpfCnpj'       => '12345678900',       // obrigatório (CPF ou CNPJ)
    'email'         => 'joao@teste.com',    // opcional
    'phone'         => '47999999999',       // opcional
    'mobilePhone'   => '47988888888',       // opcional
    'postalCode'    => '89000000',          // opcional
    'address'       => 'Rua Exemplo',       // opcional
    'addressNumber' => '123',               // opcional
    'complement'    => 'Apto 101',          // opcional
    'province'      => 'Centro',            // opcional
    'externalReference' => 'ID_INTERNO_123' // opcional
]);

## Atualizar CLientes
```php
$customer = $asaas->Cliente()->update($id, [
    'name'  => 'João da Silva Atualizado',
    'email' => 'novoemail@teste.com',
    // demais campos iguais ao create
]);


## Pagamentos

Gerencie cobranças únicas pelo módulo `Pagamento()`.

### Criar pagamento

```php
$payment = $asaas->Pagamento()->create([
    'customer'          => 'cus_1234567890', // obrigatório (ID do cliente)
    'billingType'       => 'BOLETO',         // obrigatório (BOLETO | PIX | CREDIT_CARD | UNDEFINED)
    'value'             => 100.00,           // obrigatório (valor da cobrança)
    'dueDate'           => '2025-09-10',     // obrigatório (YYYY-MM-DD)
    
    // Campos opcionais
    'description'       => 'Mensalidade Setembro',
    'externalReference' => 'PEDIDO-0001',
    'installmentCount'  => 3,                // nº de parcelas (opcional, só se parcelado)
    'installmentValue'  => 50.00,            // valor de cada parcela (opcional)
    'discount' => [
        'value'    => 10.00,
        'dueDateLimitDays' => 5,            // até quantos dias antes do vencimento aplicar
        'type'     => 'FIXED'               // FIXED ou PERCENTAGE
    ],
    'fine' => [
        'value'    => 2.0                   // multa (% sobre valor)
    ],
    'interest' => [
        'value'    => 1.0                   // juros (% ao mês)
    ],
    'postalService'     => false,           // se deve enviar boleto por correio
]);


## Payment Links

Os links de pagamento permitem gerar URLs para que o cliente finalize a cobrança diretamente pelo checkout do Asaas.

### Listar todos
```php
$links = $asaas->PagamentoLink()->getAll();

### Buscar por id
```php
$link = $asaas->PagamentoLink()->getById($id);


### Criar Link de Pagamento
```php
$link = $asaas->PagamentoLink()->create([
    'name'              => 'Mensalidade Setembro', // obrigatório (nome do link)
    'description'       => 'Plano Mensal - R$100,00',
    'billingType'       => 'BOLETO',               // BOLETO | PIX | CREDIT_CARD | UNDEFINED
    'chargeType'        => 'DETACHED',             // DETACHED | RECURRENT | INSTALLMENT
    'value'             => 100.00,                 // obrigatório se chargeType = DETACHED
    'dueDateLimitDays'  => 5,                      // prazo em dias após vencimento
    'endDate'           => '2025-12-31',           // data limite para uso do link
    'subscriptionCycle' => 'MONTHLY',              // se chargeType = RECURRENT
    'maxInstallmentCount' => 12,                   // se chargeType = INSTALLMENT
    'notificationEnabled' => true,                 // envia notificações automáticas
]);

### Atualizar link
```php
$link = $asaas->PagamentoLink()->update($id, [
    'name'        => 'Plano Mensal Atualizado',
    'description' => 'Nova descrição do plano',
]);


## Assinaturas

Gerencie planos recorrentes pelo módulo `Assinatura()`.

### Listar todas
```php
$subscriptions = $asaas->Assinatura()->getAll();


### Listar por id
```php
$subscription = $asaas->Assinatura()->getById($id);


### Criar Assinatura
```php
$subscription = $asaas->Assinatura()->create([
    'customer'    => 'cus_1234567890',   // obrigatório (ID do cliente)
    'billingType' => 'BOLETO',           // obrigatório (BOLETO | PIX | CREDIT_CARD)
    'value'       => 99.90,              // obrigatório
    'nextDueDate' => '2025-09-10',       // obrigatório (YYYY-MM-DD)
    'cycle'       => 'MONTHLY',          // obrigatório (WEEKLY | BIWEEKLY | MONTHLY | BIMONTHLY | QUARTERLY | SEMIANNUALLY | YEARLY)
    
    // opcionais
    'description' => 'Plano Mensal',
    'endDate'     => '2026-09-10',       // data de término da recorrência
    'maxPayments' => 12,                 // número máximo de cobranças
    'externalReference' => 'ASSINATURA-001',

    // apenas se billingType = CREDIT_CARD
    'creditCard' => [
        'holderName'  => 'Nome no Cartão',
        'number'      => '4111111111111111',
        'expiryMonth' => '12',
        'expiryYear'  => '2026',
        'ccv'         => '123',
    ],
    'creditCardHolderInfo' => [
        'name'        => 'Nome Cliente',
        'email'       => 'cliente@teste.com',
        'cpfCnpj'     => '12345678900',
        'postalCode'  => '89000000',
        'addressNumber' => '123',
        'phone'       => '47999999999',
    ],
    // ou use 'creditCardToken' => 'tok_abc123'
]);


### Atualizar Assinatura
```php
$subscription = $asaas->Assinatura()->update($id, [
    'value'       => 129.90,
    'description' => 'Plano Mensal Atualizado',
    // pode enviar os mesmos campos do create
]);


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