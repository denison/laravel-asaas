<?php

namespace Tests\Unit\Factories;

use PHPUnit\Framework\TestCase;
use Denison\AsaasPackage\Factories\ConnectionFactory;

class ConnectionFactoryTest extends TestCase
{
    /** @test */
    public function it_creates_connection_instance()
    {
        $connection = ConnectionFactory::create();
        
        $this->assertNotNull($connection);
    }

    /** @test */
    public function it_creates_different_instances_on_multiple_calls()
    {
        $connection1 = ConnectionFactory::create();
        $connection2 = ConnectionFactory::create();
        
        $this->assertNotSame($connection1, $connection2);
    }
}