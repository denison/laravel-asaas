<?php

namespace Denison\AsaasPackage\DTO\Payment;

use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class PaymentDTO{
    private $customer;
    private $billingType;
    private $value;
    private $dueDate;
    private $description;
    private $daysAfterDueDateToRegistrationCancellation;
    private $externalReference;
    private $installmentCount;
    private $totalValue;
    private $installmentValue;
    private $discount;
    private $interest;
    private $fine;
    private $postalService;
    private $split;
    private $callback;

    private function __construct(
        string $customer,
        string $billingType,
        float $value,
        Carbon $dueDate,
        ?string $description,
        ?int $daysAfterDueDateToRegistrationCancellation,
        ?string $externalReference,
        ?int $installmentCount,
        ?float $totalValue,
        ?float $installmentValue,
        ?array $discount,
        ?array $interest,
        ?array $fine,
        ?array $postalService,
        ?array $split,
        ?array $callback,
    )
    {
        $this->customer = $customer;
        $this->billingType = $billingType;
        $this->value = $value;
        $this->dueDate = $dueDate;
        $this->description = $description;
        $this->daysAfterDueDateToRegistrationCancellation = $daysAfterDueDateToRegistrationCancellation;
        $this->externalReference = $externalReference;
        $this->installmentCount = $installmentCount;
        $this->totalValue = $totalValue;
        $this->installmentValue = $installmentValue;
        $this->externalReference = $externalReference;
        $this->discount = $discount;
        $this->discount = $discount;
        $this->interest = $interest;
        $this->fine = $fine;
        $this->postalService = $postalService;
        $this->split = $split;
        $this->callback = $callback;
    }

    public static function create(array $data): self
    {
        // Definição das regras de validação
        $validator = Validator::make($data, [
            'customer' => 'required|string',
            'billingType' => 'required|string',
            'value' => 'required|numeric',
            'dueDate' => 'required|date',
            'description' => 'nullable|string',
            'daysAfterDueDateToRegistrationCancellation' => 'nullable|integer',
            'externalReference' => 'nullable|string',
            'installmentCount' => 'nullable|integer',
            'totalValue' => 'nullable|numeric',
            'installmentValue' => 'nullable|numeric',
            'discount' => 'nullable|array',
            'interest' => 'nullable|array',
            'fine' => 'nullable|array',
            'postalService' => 'nullable|array',
            'split' => 'nullable|array',
            'callback' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            throw new \InvalidArgumentException($validator->errors()->first());
        }

        return new self(
            $data['customer'],
            $data['billingType'],
            $data['value'],
            Carbon::parse($data['dueDate']),
            $data['description'] ?? null,
            $data['daysAfterDueDateToRegistrationCancellation'] ?? null,
            $data['externalReference'] ?? null,
            $data['installmentCount'] ?? null,
            $data['totalValue'] ?? null,
            $data['installmentValue'] ?? null,
            $data['discount'] ?? null,
            $data['interest'] ?? null,
            $data['fine'] ?? null,
            $data['postalService'] ?? null,
            $data['split'] ?? null,
            $data['callback'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'customer' => $this->customer,
            'billingType' => $this->billingType,
            'value' => $this->value,
            'dueDate' => $this->dueDate,
            'description' => $this->description,
            'daysAfterDueDateToRegistrationCancellation' => $this->daysAfterDueDateToRegistrationCancellation ,
            'externalReference' => $this->externalReference,
            'installmentCount' => $this->installmentCount,
            'totalValue' => $this->totalValue,
            'installmentValue' => $this->installmentValue,
            'discount' => $this->discount,
            'interest' => $this->interest,
            'fine' => $this->fine,
            'postalService' => $this->postalService,
            'split' => $this->split,
            'callback' => $this->callback,
        ];
    }
}