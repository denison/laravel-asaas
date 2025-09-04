<?php

namespace Denison\AsaasPackage\DTO\Subscription;

use InvalidArgumentException;

class SubscriptionDTO
{
    public string $customer;
    public string $billingType;
    public float $value;
    public string $nextDueDate;
    public string $cycle;
    public ?string $description = null;
    public ?array $creditCard = null;
    public ?array $creditCardHolderInfo = null;

    public static function create(array $data): self
    {
        foreach (['customer', 'billingType', 'value', 'nextDueDate', 'cycle'] as $field) {
            if (empty($data[$field])) {
                throw new InvalidArgumentException("The {$field} field is required.");
            }
        }

        $dto = new self();
        $dto->customer = $data['customer'];
        $dto->billingType = $data['billingType'];
        $dto->value = (float) $data['value'];
        $dto->nextDueDate = $data['nextDueDate'];
        $dto->cycle = $data['cycle'];
        $dto->description = $data['description'] ?? null;
        $dto->creditCard = $data['creditCard'] ?? null;
        $dto->creditCardHolderInfo = $data['creditCardHolderInfo'] ?? null;

        return $dto;
    }

    public function toArray(): array
    {
        $array = [
            'customer' => $this->customer,
            'billingType' => $this->billingType,
            'value' => $this->value,
            'nextDueDate' => $this->nextDueDate,
            'cycle' => $this->cycle,
        ];

        if ($this->description) {
            $array['description'] = $this->description;
        }

        if ($this->creditCard) {
            $array['creditCard'] = $this->creditCard;
        }

        if ($this->creditCardHolderInfo) {
            $array['creditCardHolderInfo'] = $this->creditCardHolderInfo;
        }

        return $array;
    }
}
