<?php

namespace Denison\AsaasPackage\DTO\PaymentLink;

use Illuminate\Support\Facades\Validator;

class PaymentLinkUpdateDTO
{
    private ?string $name;
    /** @var string|array|null */
    private $billingType;          
    private ?string $chargeType;   // 'DETACHED' | 'RECURRENT'
    private ?float $value;
    private ?float $totalValue;
    private ?int $dueDateLimitDays;
    private ?string $description;
    private ?int $maxInstallmentCount;
    private ?string $redirectUrl;
    private ?string $callbackUrl;
    private ?string $externalReference;

    private function __construct(
        ?string $name = null,
        $billingType = null,
        ?string $chargeType = null,
        ?float $value = null,
        ?float $totalValue = null,
        ?int $dueDateLimitDays = null,
        ?string $description = null,
        ?int $maxInstallmentCount = null,
        ?string $redirectUrl = null,
        ?string $callbackUrl = null,
        ?string $externalReference = null
    ) {
        $this->name                = $name;
        $this->billingType         = $billingType;
        $this->chargeType          = $chargeType;
        $this->value               = $value;
        $this->totalValue          = $totalValue;
        $this->dueDateLimitDays    = $dueDateLimitDays;
        $this->description         = $description;
        $this->maxInstallmentCount = $maxInstallmentCount;
        $this->redirectUrl         = $redirectUrl;
        $this->callbackUrl         = $callbackUrl;
        $this->externalReference   = $externalReference;
    }

    public static function create(array $data): self
    {
        $validator = Validator::make($data, [
            'name'               => 'nullable|string',
            'billingType'        => 'nullable',
            'chargeType'         => 'nullable|string|in:DETACHED,RECURRENT',
            // em update, ambos opcionais; se vierem, precisam ser numéricos
            'value'              => 'nullable|numeric',
            'totalValue'         => 'nullable|numeric',
            'dueDateLimitDays'   => 'nullable|integer|min:1',
            'description'        => 'nullable|string',
            'maxInstallmentCount'=> 'nullable|integer|min:1',
            'redirectUrl'        => 'nullable|url',
            'callbackUrl'        => 'nullable|url',
            'externalReference'  => 'nullable|string',
        ]);

        if ($validator->fails()) {
            throw new \InvalidArgumentException($validator->errors()->first());
        }

        return new self(
            $data['name'] ?? null,
            $data['billingType'] ?? null,
            $data['chargeType'] ?? null,
            isset($data['value']) ? (float)$data['value'] : null,
            isset($data['totalValue']) ? (float)$data['totalValue'] : null,
            isset($data['dueDateLimitDays']) ? (int)$data['dueDateLimitDays'] : null,
            $data['description'] ?? null,
            isset($data['maxInstallmentCount']) ? (int)$data['maxInstallmentCount'] : null,
            $data['redirectUrl'] ?? null,
            $data['callbackUrl'] ?? null,
            $data['externalReference'] ?? null
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'name'               => $this->name,
            'billingType'        => $this->billingType,
            'chargeType'         => $this->chargeType,
            'value'              => $this->value,
            'totalValue'         => $this->totalValue,
            'dueDateLimitDays'   => $this->dueDateLimitDays,
            'description'        => $this->description,
            'maxInstallmentCount'=> $this->maxInstallmentCount,
            'redirectUrl'        => $this->redirectUrl,
            'callbackUrl'        => $this->callbackUrl,
            'externalReference'  => $this->externalReference,
        ], fn($v) => $v !== null);
    }
}
