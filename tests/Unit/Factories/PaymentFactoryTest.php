<?php

namespace Tests\Unit\Factories\Payment;

use PHPUnit\Framework\TestCase;
use Denison\AsaasPackage\Factories\Payment\PaymentFactory;
use Denison\AsaasPackage\Contracts\PaymentInterface;

class PaymentFactoryTest extends TestCase
{
    /** @test */
    public function it_creates_payment_instance_with_connection()
    {
        // Mock da Connection 
        $mockConnection = $this->createMock('Denison\AsaasPackage\Connection');
        
        $payment = PaymentFactory::create($mockConnection);
        
        // Testa se retorna uma instância que implementa PaymentInterface
        $this->assertInstanceOf(PaymentInterface::class, $payment);
    }

    /** @test */
    public function it_creates_different_instances_on_multiple_calls()
    {
        $mockConnection = $this->createMock('Denison\AsaasPackage\Connection');
        
        $payment1 = PaymentFactory::create($mockConnection);
        $payment2 = PaymentFactory::create($mockConnection);
        
        // Devem ser instâncias diferentes
        $this->assertNotSame($payment1, $payment2);
    }
}