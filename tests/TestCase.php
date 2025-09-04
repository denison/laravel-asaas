<?php

namespace Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Denison\AsaasPackage\AsaasServiceProvider;

abstract class TestCase extends OrchestraTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [AsaasServiceProvider::class];
    }

    protected function getEnvironmentSetUp($app)
    {
        // Carrega o .env da biblioteca
        if (file_exists(__DIR__ . '/../.env')) {
            $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
            $dotenv->load();
        }

        // Configurações específicas para testes
        $app['config']->set('asaas.api_url_sandbox', env('ASAAS_API_URL_SANDBOX'));
        $app['config']->set('asaas.api_key_sandbox', env('ASAAS_API_KEY_SANDBOX'));
        $app['config']->set('app.env', 'local'); // Força sandbox
    }
}