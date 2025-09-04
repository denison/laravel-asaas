<?php

namespace Tests\Unit\Factories;

use PHPUnit\Framework\TestCase;
use Denison\AsaasPackage\Factories\CustomerFactory;
use Denison\AsaasPackage\Contracts\CustomerInterface;

class CustomerFactoryTest extends TestCase
{
    /** @test */
    public function it_creates_customer_instance_with_connection()
    {
        // Usar um mock da Connection 
        $mockConnection = $this->createMock('Denison\AsaasPackage\Connection');
        
        $customer = CustomerFactory::create($mockConnection);
        
        // Testa se retorna uma instância que implementa CustomerInterface
        $this->assertInstanceOf(CustomerInterface::class, $customer);
    }

    /** @test */
    public function it_creates_different_instances_on_multiple_calls()
    {
        $mockConnection = $this->createMock('Denison\AsaasPackage\Connection');
        
        $customer1 = CustomerFactory::create($mockConnection);
        $customer2 = CustomerFactory::create($mockConnection);
        
        // Devem ser instâncias diferentes
        $this->assertNotSame($customer1, $customer2);
    }
}