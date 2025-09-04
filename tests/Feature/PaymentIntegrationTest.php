<?php

namespace Tests\Feature;

use Tests\TestCase;
use Denison\AsaasPackage\Asaas;

class PaymentIntegrationTest extends TestCase
{
    protected $asaas;
    protected static $sharedCustomerId;
    protected $createdPaymentIds = [];

    protected function setUp(): void
    {
        parent::setUp();

        // Garante que NÃO é production (ConnectionFactory usa env('APP_ENV'))
        // Isso funciona tanto em Laravel quanto em execução direta do PHPUnit.
        putenv('APP_ENV=local');
        $_ENV['APP_ENV'] = 'local';

        // Instancia a fachada (usa ConnectionFactory->env())
        $this->asaas = new Asaas();

        // Cria o cliente UMA vez por classe
        if (!self::$sharedCustomerId) {
            echo "\n🔄 Criando cliente compartilhado...\n";
            try {
                $payload = [
                    'name'    => 'Ronaldinho Customer ' . date('YmdHis'),
                    'cpfCnpj' => $this->validCpf(),
                    'email'   => $this->uniqueEmail('phpunit'),
                ];
                $res = $this->asaas->Cliente()->create($payload);

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
    public function it_can_create_boleto_payment()
    {
        $this->assertNotEmpty(self::$sharedCustomerId, 'Cliente não definido');

        $dueDate = date('Y-m-d', strtotime('+30 days'));
        $paymentData = [
            'customer'    => self::$sharedCustomerId,
            'billingType' => 'BOLETO',
            'value'       => 100.50,
            'dueDate'     => $dueDate,
            'description' => 'Pagamento teste - Boleto PHPUnit',
        ];

        echo "\n🔄 Criando boleto...\n";
        echo "📋 Cliente: " . self::$sharedCustomerId . "\n";
        echo "💰 Valor: R$ " . $paymentData['value'] . "\n";
        echo "📅 Vencimento: " . $dueDate . "\n";

        try {
            $response = $this->asaas->Pagamento()->create($paymentData);

            $this->assertIsArray($response);
            $this->assertArrayHasKey('id', $response);

            echo "✅ Boleto criado: " . $response['id'] . "\n";
            echo "🏦 Tipo: " . ($response['billingType'] ?? 'N/A') . "\n";
            echo "💵 Valor: R$ " . ($response['value'] ?? 'N/A') . "\n";

            $this->assertSame(self::$sharedCustomerId, $response['customer']);
            $this->assertSame('BOLETO', $response['billingType']);
            $this->assertSame(100.50, $response['value']);

            $this->createdPaymentIds[] = $response['id'];

        } catch (\Throwable $e) {
            $this->fail('Falha ao criar pagamento: ' . $e->getMessage());
        }
    }

    protected function tearDown(): void
    {
        if (!empty($this->createdPaymentIds)) {
            echo "\n📊 Pagamentos criados: " . count($this->createdPaymentIds) . "\n";
        }
        parent::tearDown();
    }

    // ===== Helpers mínimos =====
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
