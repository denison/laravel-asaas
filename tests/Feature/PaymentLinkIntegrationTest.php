<?php

// tests/Feature/PaymentLinkIntegrationTest.php
namespace Tests\Feature;

use Tests\TestCase;
use Denison\AsaasPackage\Asaas;

class PaymentLinkIntegrationTest extends TestCase
{
    protected $asaas;
    protected static $createdLinkId;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        // Carrega .env (sem Laravel)
        $root = __DIR__ . '/../../';
        if (file_exists($root . '.env')) {
            \Dotenv\Dotenv::createImmutable($root)->safeLoad();
        }
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->asaas = new Asaas();
    }

    /** @test */
    public function it_can_create_payment_link_checkout()
    {
        $payload = [
            'name'             => 'Plano Mensal PHPUnit ' . date('YmdHis'),
            // se quiser restringir a um tipo, informe 'CREDIT_CARD'; se não informar, vale a config do link na conta
            'billingType'      => 'CREDIT_CARD',
            'chargeType'       => 'DETACHED', // avulso; para recorrência use 'RECURRENT'
            'value'            => 99.90,
            'dueDateLimitDays' => 5,
            'description'      => 'Acesso 30 dias (teste)',
            // opcionais:
            // 'maxInstallmentCount' => 3,
            // 'redirectUrl'        => 'https://seusite.com/sucesso',
            // 'callbackUrl'        => 'https://seusite.com/webhook',
            // 'externalReference'  => 'PLANO_PREMIUM_2025'
        ];

        echo "\n🔄 Criando PaymentLink...\n";

        try {
            $res = $this->asaas->PagamentoLink()->create($payload);

            $this->assertIsArray($res);
            $this->assertArrayHasKey('id', $res, 'Resposta sem id do payment link');
            $this->assertArrayHasKey('url', $res, 'Resposta sem url do checkout');

            self::$createdLinkId = $res['id'];

            echo "✅ Link criado: {$res['id']}\n";
            echo "🔗 URL: {$res['url']}\n";

        } catch (\Throwable $e) {
            $this->fail('Falha ao criar PaymentLink: ' . $e->getMessage());
        }
    }

    /** @test */
    public function it_can_find_payment_link_by_id()
    {
        $this->assertNotEmpty(self::$createdLinkId, 'Link não criado no teste anterior');

        echo "\n🔎 Buscando PaymentLink por ID...\n";

        try {
            $res = $this->asaas->PagamentoLink()->getById(self::$createdLinkId);

            $this->assertIsArray($res);
            $this->assertSame(self::$createdLinkId, $res['id']);

            echo "✅ Link encontrado: {$res['id']}\n";

        } catch (\Throwable $e) {
            $this->fail('Falha ao buscar PaymentLink: ' . $e->getMessage());
        }
    }

    /** @test */
    public function it_can_list_payment_links()
    {
        echo "\n📜 Listando PaymentLinks...\n";

        try {
            $res = $this->asaas->PagamentoLink()->getAll();

            $this->assertIsArray($res);
            // dependendo do seu ResponseProcessor, pode vir ['data'=>[]] ou array direto
            $this->assertTrue(isset($res['data']) || isset($res[0]));

            $count = isset($res['data']) ? count($res['data']) : count($res);
            echo "✅ Total retornado: {$count}\n";

        } catch (\Throwable $e) {
            $this->fail('Falha ao listar PaymentLinks: ' . $e->getMessage());
        }
    }
}
