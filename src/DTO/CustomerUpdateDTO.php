<?php

namespace Denison\AsaasPackage\DTO;

use Illuminate\Support\Facades\Validator;

class CustomerUpdateDTO
{
    private ?string $name;
    private ?string $cpfCnpj;
    private ?string $email;
    private ?string $phone;
    private ?string $mobilePhone;
    private ?string $address;
    private ?string $addressNumber;
    private ?string $complement;
    private ?string $province;
    private ?string $postalCode;
    private ?string $externalReference;
    private ?bool $notificationDisabled;
    private ?string $additionalEmails;
    private ?string $municipalInscription;
    private ?string $stateInscription;
    private ?string $observations;
    private ?string $groupName;
    private ?string $company;

    private function __construct(
        ?string $name = null,
        ?string $cpfCnpj = null,
        ?string $email = null,
        ?string $phone = null,
        ?string $mobilePhone = null,
        ?string $address = null,
        ?string $addressNumber = null,
        ?string $complement = null,
        ?string $province = null,
        ?string $postalCode = null,
        ?string $externalReference = null,
        ?bool $notificationDisabled = null,
        ?string $additionalEmails = null,
        ?string $municipalInscription = null,
        ?string $stateInscription = null,
        ?string $observations = null,
        ?string $groupName = null,
        ?string $company = null
    ) {
        $this->name = $name;
        $this->cpfCnpj = $cpfCnpj;
        $this->email = $email;
        $this->phone = $phone;
        $this->mobilePhone = $mobilePhone;
        $this->address = $address;
        $this->addressNumber = $addressNumber;
        $this->complement = $complement;
        $this->province = $province;
        $this->postalCode = $postalCode;
        $this->externalReference = $externalReference;
        $this->notificationDisabled = $notificationDisabled;
        $this->additionalEmails = $additionalEmails;
        $this->municipalInscription = $municipalInscription;
        $this->stateInscription = $stateInscription;
        $this->observations = $observations;
        $this->groupName = $groupName;
        $this->company = $company;
    }

    public static function create(array $data): self
    {
        // Definição das regras de validação
        $validator = Validator::make($data, [
            'name' => 'nullable|string',
            'cpfCnpj' => 'nullable|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'mobilePhone' => 'nullable|string',
            'address' => 'nullable|string',
            'addressNumber' => 'nullable|string',
            'complement' => 'nullable|string',
            'province' => 'nullable|string',
            'postalCode' => 'nullable|string',
            'externalReference' => 'nullable|string',
            'notificationDisabled' => 'nullable|boolean',
            'additionalEmails' => 'nullable|string',
            'municipalInscription' => 'nullable|string',
            'stateInscription' => 'nullable|string',
            'observations' => 'nullable|string',
            'groupName' => 'nullable|string',
            'company' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            throw new \InvalidArgumentException($validator->errors()->first());
        }
        
        return new self(
            $data['name'] ?? null,
            $data['cpfCnpj'] ?? null,
            $data['email'] ?? null,
            $data['phone'] ?? null,
            $data['mobilePhone'] ?? null,
            $data['address'] ?? null,
            $data['addressNumber'] ?? null,
            $data['complement'] ?? null,
            $data['province'] ?? null,
            $data['postalCode'] ?? null,
            $data['externalReference'] ?? null,
            $data['notificationDisabled'] ?? null,
            $data['additionalEmails'] ?? null,
            $data['municipalInscription'] ?? null,
            $data['stateInscription'] ?? null,
            $data['observations'] ?? null,
            $data['groupName'] ?? null,
            $data['company'] ?? null
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'cpfCnpj' => $this->cpfCnpj,
            'email' => $this->email,
            'phone' => $this->phone,
            'mobilePhone' => $this->mobilePhone,
            'address' => $this->address,
            'addressNumber' => $this->addressNumber,
            'complement' => $this->complement,
            'province' => $this->province,
            'postalCode' => $this->postalCode,
            'externalReference' => $this->externalReference,
            'notificationDisabled' => $this->notificationDisabled,
            'additionalEmails' => $this->additionalEmails,
            'municipalInscription' => $this->municipalInscription,
            'stateInscription' => $this->stateInscription,
            'observations' => $this->observations,
            'groupName' => $this->groupName,
            'company' => $this->company
        ], fn($value) => $value !== null);
    }
}