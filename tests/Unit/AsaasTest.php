<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Denison\AsaasPackage\Asaas;

class AsaasTest extends TestCase
{
    protected $asaas;

    protected function setUp(): void
    {
        parent::setUp();
        $this->asaas = new Asaas();
    }

    /** @test */
    public function it_can_be_instantiated()
    {
        $this->assertInstanceOf(Asaas::class, $this->asaas);
    }

    /** @test */
    public function it_creates_connection_when_instantiated()
    {
        $connection = $this->asaas->getConnection();
        
        $this->assertNotNull($connection);
    }

    /** @test */
    public function it_returns_customer_instance()
    {
        $cliente = $this->asaas->Cliente();
        
        $this->assertNotNull($cliente);
    }

    /** @test */
    public function it_returns_payment_instance()
    {
        $pagamento = $this->asaas->Pagamento();
        
        $this->assertNotNull($pagamento);
    }

    /** @test */
    public function it_uses_same_connection_for_multiple_calls()
    {
        $connection1 = $this->asaas->getConnection();
        $connection2 = $this->asaas->getConnection();
        
        $this->assertSame($connection1, $connection2);
    }

    /** @test */
    public function multiple_instances_have_different_connections()
    {
        $asaas1 = new Asaas();
        $asaas2 = new Asaas();
        
        $connection1 = $asaas1->getConnection();
        $connection2 = $asaas2->getConnection();
        
        $this->assertNotSame($connection1, $connection2);
    }
}