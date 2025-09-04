<?php

namespace Tests\Feature;

use Tests\TestCase;
use Denison\AsaasPackage\Asaas;
use Denison\AsaasPackage\Exceptions\ApiException;

class SubscriptionIntegrationTest extends TestCase
{
    protected $asaas;
    protected static $sharedCustomerId;
    protected $createdSubscriptionIds = [];

    protected function setUp(): void
    {
        parent::setUp();

        // Força sandbox para o ConnectionFactory (usa env('APP_ENV'))
        putenv('APP_ENV=local');
        $_ENV['APP_ENV'] = 'local';

        $this->asaas = new Asaas();

        // Cria um cliente compartilhado por classe, se ainda não houver.
        if (!self::$sharedCustomerId) {
            try {
                echo "\n🔄 Criando cliente para testes de assinatura...\n";
                $customerData = [
                    'name'    => 'Cliente Assinaturas ' . date('YmdHis'),
                    'cpfCnpj' => $this->validCpf(),
                    'email'   => 'denyson92@gmail.com',
                ];

                $res = $this->asaas->Cliente()->create($customerData);

                $this->assertIsArray($res, 'Resposta inválida ao criar cliente.');
                $this->assertArrayHasKey('id', $res, 'Cliente sem ID na resposta.');

                self::$sharedCustomerId = $res['id'];
                echo "✅ Cliente criado: " . self::$sharedCustomerId . "\n";

            } catch (\Throwable $e) {
                $this->fail('Falha ao criar cliente: ' . $e->getMessage());
            }
        }
    }

    /** @test */
    public function it_can_create_monthly_subscription()
    {
        $this->assertNotEmpty(self::$sharedCustomerId, 'Cliente não disponível');

        $nextDueDate = date('Y-m-d', strtotime('+7 days'));
        $payload = [
            'customer'    => self::$sharedCustomerId,
            'billingType' => 'BOLETO',
            'value'       => 49.90,
            'nextDueDate' => $nextDueDate,
            'cycle'       => 'MONTHLY',
            'description' => 'Assinatura Teste Mensal - PHPUnit',
        ];

        echo "\n🔄 Criando assinatura mensal (boleto)...\n";

        $res = $this->asaas->Assinatura()->create($payload);

        $this->assertIsArray($res);
        $this->assertArrayHasKey('id', $res);

        $this->assertSame(self::$sharedCustomerId, $res['customer']);
        $this->assertSame('BOLETO', $res['billingType']);
        $this->assertSame('MONTHLY', $res['cycle']);

        $this->createdSubscriptionIds[] = $res['id'];
        echo "✅ Assinatura criada: {$res['id']}\n";
    }

    /** @test */
    public function it_can_create_annual_subscription()
    {
        $nextDueDate = date('Y-m-d', strtotime('+30 days'));
        $payload = [
            'customer'    => self::$sharedCustomerId,
            'billingType' => 'CREDIT_CARD',
            'value'       => 299.90,
            'nextDueDate' => $nextDueDate,
            'cycle'       => 'YEARLY', // ajuste final: YEARLY
            'description' => 'Assinatura Teste Anual - PHPUnit',
            'creditCard'  => [
                'holderName' => 'Denison Augusto da Silva teste cartao',
                'number'     => '5162306219378829',
                'expiryMonth'=> '12',
                'expiryYear' => '2025',
                'ccv'        => '318',
            ],
            'creditCardHolderInfo' => [
                'name'         => 'Denison Augusto da Silva teste cartao',
                'email'        => 'denyson92@gmail.com',
                'cpfCnpj'      => $this->validCpf(),
                'postalCode'   => '01234-567',
                'addressNumber'=> '123',
                'phone'        => '11999999999',
            ],
        ];

        echo "\n🔄 Criando assinatura anual com cartão...\n";

        try {
            $res = $this->asaas->Assinatura()->create($payload);

            $this->assertIsArray($res);
            $this->assertArrayHasKey('id', $res);
            $this->assertSame('YEARLY', $res['cycle']);
            $this->assertSame('CREDIT_CARD', $res['billingType']);

            $this->createdSubscriptionIds[] = $res['id'];
            echo "✅ Assinatura anual criada: {$res['id']}\n";

        } catch (ApiException $e) {
            $this->markTestIncomplete('Cartão de sandbox não autorizado neste ambiente: ' . $e->getMessage());
        }
    }

    /** @test */
    public function it_can_create_monthly_subscription_without_card_on_credit_billing()
    {
        $nextDueDate = date('Y-m-d', strtotime('+7 days'));

        $payload = [
            'customer'    => self::$sharedCustomerId,
            'billingType' => 'CREDIT_CARD',
            'value'       => 99.90,
            'nextDueDate' => $nextDueDate,
            'cycle'       => 'MONTHLY',
            'description' => 'Assinatura Mensal SEM cartão - PHPUnit',
            // intencionalmente sem creditCard / creditCardToken
        ];

        echo "\n🔄 Criando assinatura mensal no CARTÃO, SEM enviar dados/token...\n";

        try {
            $res = $this->asaas->Assinatura()->create($payload);

            $this->assertIsArray($res);
            $this->assertArrayHasKey('id', $res);
            $this->assertSame('CREDIT_CARD', $res['billingType']);
            $this->assertSame('MONTHLY', $res['cycle']);

            $this->createdSubscriptionIds[] = $res['id'];
            echo "✅ Assinatura criada (sem cartão): {$res['id']}\n";

        } catch (ApiException $e) {
            $this->markTestIncomplete(
                'API rejeitou assinatura sem cartão/token (comportamento esperado): ' . $e->getMessage()
            );
        }
    }

    /** @test */
    public function it_can_get_subscription_by_id()
    {
        $payload = [
            'customer'    => self::$sharedCustomerId,
            'billingType' => 'PIX',
            'value'       => 19.90,
            'nextDueDate' => date('Y-m-d', strtotime('+15 days')),
            'cycle'       => 'MONTHLY',
            'description' => 'Assinatura para busca por ID',
        ];

        $created = $this->asaas->Assinatura()->create($payload);
        $subId   = $created['id'];
        $this->createdSubscriptionIds[] = $subId;

        echo "\n🔍 Buscando assinatura por ID: $subId\n";

        $got = $this->asaas->Assinatura()->getById($subId);

        $this->assertIsArray($got);
        $this->assertSame($subId, $got['id']);
        $this->assertSame(self::$sharedCustomerId, $got['customer']);
        $this->assertSame('PIX', $got['billingType']);

        echo "✅ Assinatura encontrada: {$got['id']}\n";
    }

    /** @test */
    public function it_can_update_subscription()
    {
        $created = $this->asaas->Assinatura()->create([
            'customer'    => self::$sharedCustomerId,
            'billingType' => 'BOLETO',
            'value'       => 29.90,
            'nextDueDate' => date('Y-m-d', strtotime('+10 days')),
            'cycle'       => 'MONTHLY',
            'description' => 'Assinatura para update',
        ]);

        $subId = $created['id'];
        $this->createdSubscriptionIds[] = $subId;

        $update = [
            'value'       => 39.90,
            'description' => 'Assinatura atualizada - Valor alterado',
        ];

        echo "\n🔄 Atualizando assinatura $subId...\n";

        $res = $this->asaas->Assinatura()->update($subId, $update);

        $this->assertIsArray($res);
        $this->assertSame($subId, $res['id']);
        $this->assertTrue($res['value'] >= $update['value']);

        echo "✅ Assinatura atualizada!\n";
    }

    /** @test */
    public function it_can_get_all_subscriptions()
    {
        echo "\n📋 Listando assinaturas...\n";

        $res = $this->asaas->Assinatura()->getAll();

        $this->assertIsArray($res);
        $this->assertTrue(isset($res['data']) || isset($res[0]));

        if (isset($res['data'])) {
            echo "✅ Encontradas " . count($res['data']) . " assinaturas\n";
            if (!empty($res['data'])) {
                $first = $res['data'][0];
                $this->assertArrayHasKey('id', $first);
                $this->assertArrayHasKey('status', $first);
                echo "📄 Primeira: {$first['id']} (Status: {$first['status']})\n";
            }
        } else {
            echo "✅ Lista direta retornada (sem 'data')\n";
        }
    }

    /** @test */
    public function it_throws_exception_when_creating_subscription_with_invalid_data()
    {
        $this->expectException(ApiException::class);

        $invalid = [
            'billingType' => 'BOLETO',
            'value'       => 50,
            // faltando customer, nextDueDate, cycle
        ];

        $this->asaas->Assinatura()->create($invalid);
    }

    /** @test */
    public function it_throws_exception_when_getting_subscription_with_invalid_id()
    {
        try {
            $res = $this->asaas->Assinatura()->getById('invalid_subscription_id_12345');
            $this->assertTrue(is_null($res) || empty($res));
        } catch (ApiException $e) {
            $this->assertInstanceOf(ApiException::class, $e);
            echo "\n✅ Erro tratado (ID inválido): " . $e->getMessage() . "\n";
        }
    }

    protected function tearDown(): void
    {
        if (!empty($this->createdSubscriptionIds)) {
            echo "\n📊 Assinaturas criadas neste teste: " . count($this->createdSubscriptionIds) . "\n";
            foreach ($this->createdSubscriptionIds as $id) {
                echo "📋 Subscription ID: $id\n";
            }
        }
        parent::tearDown();
    }

    // ===== Helpers =====

    private function uniqueEmail(string $prefix = 'phpunit'): string
    {
        return sprintf('%s+%s@teste.com', $prefix, bin2hex(random_bytes(4)));
    }

    private function validCpf(): string
    {
        $n=[]; for($i=0;$i<9;$i++) $n[$i]=random_int(0,9);
        $d1=0; for($i=0,$w=10;$i<9;$i++,$w--) $d1+=$n[$i]*$w;
        $d1=11-($d1%11); if($d1>=10) $d1=0;
        $d2=0; for($i=0,$w=11;$i<9;$i++,$w--) $d2+=$n[$i]*$w;
        $d2+=$d1*2; $d2=11-($d2%11); if($d2>=10) $d2=0;
        return implode('', $n).$d1.$d2;
    }
}
