# Asaas Package

Pacote simples de pagamento para Laravel usando o Asaas.

## Instalação

```bash
composer require denison/asaas-package

## Configuração

Para usar o pacote, você precisa definir as seguintes variáveis de ambiente em seu arquivo `.env`:

### Produção
```env
APP_ENV=production
ASAAS_API_URL=https://www.asaas.com/api/v3
ASAAS_API_KEY_PRODUCTION=api_produção

### DEV
```env
ASAAS_API_URL_SANDBOX=https://sandbox.asaas.com/api/v3
ASAAS_API_KEY_SANDBOX=api_sandbox