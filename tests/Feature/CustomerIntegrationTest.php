<?php

// tests/Feature/CustomerIntegrationTest.php
namespace Tests\Feature;

use Tests\TestCase;
use Denison\AsaasPackage\Asaas;
use Denison\AsaasPackage\Exceptions\ApiException;
use Denison\AsaasPackage\Exceptions\ConnectionException;

class CustomerIntegrationTest extends TestCase
{
    protected $asaas;
    protected $createdCustomerIds = [];

    protected function setUp(): void
    {
        parent::setUp();
        
        // Forçar ambiente sandbox para testes
        config([
            'app.env' => 'local', // Força sandbox
            'asaas.api_url_sandbox' => env('ASAAS_API_URL_SANDBOX'),
            'asaas.api_key_sandbox' => env('ASAAS_API_KEY_SANDBOX'),
        ]);
        
        $this->asaas = new Asaas();
    }

    /** @test */
    public function it_can_create_customer_in_asaas_sandbox()
    {
        $customerData = [
            'name' => 'João Silva Teste PHPUnit',
            'cpfCnpj' => '15694631072',
            'email' => 'joao.phpunit@teste.com',
            'phone' => '11999999999',
            'mobilePhone' => '11888888888',
        ];

        $response = $this->asaas->Cliente()->create($customerData);

        $this->assertNotNull($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertEquals($customerData['name'], $response['name']);
        $this->assertEquals($customerData['email'], $response['email']);
        
        // Guardar ID para limpeza
        $this->createdCustomerIds[] = $response['id'];
    }

    /** @test */
    public function it_can_get_all_customers()
    {
        $response = $this->asaas->Cliente()->getAll();

        $this->assertNotNull($response);
        $this->assertIsArray($response);
        // Deve ter pelo menos a estrutura básica
        $this->assertTrue(isset($response['data']) || isset($response[0]));
    }

    /** @test */
    public function it_can_create_and_find_customer_by_id()
    {
        // Primeiro criar um customer
        $customerData = [
            'name' => 'Maria Teste Find',
            'cpfCnpj' => '21470471043',
            'email' => 'maria.find@teste.com',
        ];

        $createResponse = $this->asaas->Cliente()->create($customerData);
        $customerId = $createResponse['id'];
        $this->createdCustomerIds[] = $customerId;

        // Depois buscar por ID
        $findResponse = $this->asaas->Cliente()->getById($customerId);

        $this->assertNotNull($findResponse);
        $this->assertEquals($customerId, $findResponse['id']);
        $this->assertEquals($customerData['name'], $findResponse['name']);
        $this->assertEquals($customerData['email'], $findResponse['email']);
    }

    /** @test */
    public function it_can_create_and_update_customer()
    {
        // Criar customer
        $customerData = [
            'name' => 'Pedro Teste Update',
            'cpfCnpj' => '24663162002',
            'email' => 'pedro.update@teste.com',
        ];

        $createResponse = $this->asaas->Cliente()->create($customerData);
        $customerId = $createResponse['id'];
        $this->createdCustomerIds[] = $customerId;

        // Atualizar customer
        $updateData = [
            'name' => 'Pedro Silva Atualizado',
            'email' => 'pedro.atualizado@teste.com',
            'phone' => '11777777777',
        ];

        $updateResponse = $this->asaas->Cliente()->update($customerId, $updateData);

        $this->assertNotNull($updateResponse);
        $this->assertEquals($updateData['name'], $updateResponse['name']);
        $this->assertEquals($updateData['email'], $updateResponse['email']);
        $this->assertEquals($updateData['phone'], $updateResponse['phone']);
    }

    /** @test */
    public function it_throws_exception_when_creating_customer_with_invalid_data()
    {
        $this->expectException(\InvalidArgumentException::class);

        // Dados inválidos - faltando campos obrigatórios
        $invalidData = [
            'email' => 'email@teste.com',
            // Faltando 'name' e 'cpfCnpj' que são obrigatórios
        ];

        $this->asaas->Cliente()->create($invalidData);
    }

    /** @test */
    public function it_throws_exception_when_creating_customer_with_invalid_email()
    {
        $this->expectException(\InvalidArgumentException::class);

        $invalidData = [
            'name' => 'Teste Email Inválido',
            'cpfCnpj' => '00580894037',
            'email' => 'email-invalido', // Email inválido
        ];

        $this->asaas->Cliente()->create($invalidData);
    }

    /** @test */
    public function it_handles_api_errors_gracefully()
    {
        // Tentar buscar customer com ID inválido
        try {
            $response = $this->asaas->Cliente()->getById('invalid_id_123456');
            
            // Se não lançou exceção, deve retornar null ou array vazio
            $this->assertTrue(is_null($response) || empty($response));
            
        } catch (ApiException $e) {
            // Se lançou ApiException, está tratando erro corretamente
            $this->assertInstanceOf(ApiException::class, $e);
        }
    }

    /** @test */
    public function it_creates_customer_with_complete_address()
    {
        $customerData = [
            'name' => 'Ana Completa',
            'cpfCnpj' => '55566677788',
            'email' => 'ana.completa@teste.com',
            'phone' => '1112345678',
            'address' => 'Rua das Flores',
            'addressNumber' => '123',
            'complement' => 'Apto 45',
            'province' => 'Centro',
            'postalCode' => '01234-567',
            'observations' => 'Cliente VIP de teste',
        ];

        $response = $this->asaas->Cliente()->create($customerData);

        $this->assertNotNull($response);
        $this->assertArrayHasKey('id', $response);
        $this->assertEquals($customerData['name'], $response['name']);
        $this->assertEquals($customerData['address'], $response['address']);
        $this->assertEquals($customerData['postalCode'], $response['postalCode']);
        
        $this->createdCustomerIds[] = $response['id'];
    }

    protected function tearDown(): void
    {
        // Limpeza opcional - deletar customers criados nos testes
        // (Comentado pois nem sempre a API tem endpoint de delete)
        /*
        foreach ($this->createdCustomerIds as $customerId) {
            try {
                $this->asaas->Cliente()->delete($customerId);
            } catch (\Exception $e) {
                // Ignorar erros de limpeza
            }
        }
        */
        
        parent::tearDown();
    }
}