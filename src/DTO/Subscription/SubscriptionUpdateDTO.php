<?php

namespace Denison\AsaasPackage\DTO\Subscription;

use InvalidArgumentException;

class SubscriptionUpdateDTO
{
    public ?float $value = null;
    public ?string $description = null;
    public ?string $cycle = null;
    public ?string $nextDueDate = null;

    public static function create(array $data): self
    {
        if (empty($data)) {
            throw new InvalidArgumentException("At least one field is required to update a subscription.");
        }

        $dto = new self();
        $dto->value = isset($data['value']) ? (float) $data['value'] : null;
        $dto->description = $data['description'] ?? null;
        $dto->cycle = $data['cycle'] ?? null;
        $dto->nextDueDate = $data['nextDueDate'] ?? null;

        return $dto;
    }

    public function toArray(): array
    {
        $array = [];

        if (!is_null($this->value)) {
            $array['value'] = $this->value;
        }
        if ($this->description) {
            $array['description'] = $this->description;
        }
        if ($this->cycle) {
            $array['cycle'] = $this->cycle;
        }
        if ($this->nextDueDate) {
            $array['nextDueDate'] = $this->nextDueDate;
        }

        return $array;
    }
}
