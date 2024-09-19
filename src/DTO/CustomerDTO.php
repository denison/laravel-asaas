<?php

namespace Denison\AsaasPackage\DTO;

class CustomerDTO
{
    private $name;
    private $cpfCnpj;
    private $email;
    private $phone;
    private $mobilePhone;
    private $address;
    private $addressNumber;
    private $complement;
    private $province;
    private $postalCode;
    private $externalReference;
    private $notificationDisabled;
    private $additionalEmails;
    private $municipalInscription;
    private $stateInscription;
    private $observations;
    private $groupName;
    private $company;

    private function __construct(
        string $name,
        string $cpfCnpj,
        ?string $email = null,
        ?string $phone = null,
        ?string $mobilePhone = null,
        ?string $address = null,
        ?string $addressNumber = null,
        ?string $complement = null,
        ?string $province = null,
        ?string $postalCode = null,
        ?string $externalReference = null,
        bool $notificationDisabled = false,
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
        if (empty($data['name']) || empty($data['cpfCnpj'])) {
            throw new \InvalidArgumentException('Os campos "name" e "cpfCnpj" são obrigatórios.');
        }

        return new self(
            $data['name'],
            $data['cpfCnpj'],
            $data['email'] ?? null,
            $data['phone'] ?? null,
            $data['mobilePhone'] ?? null,
            $data['address'] ?? null,
            $data['addressNumber'] ?? null,
            $data['complement'] ?? null,
            $data['province'] ?? null,
            $data['postalCode'] ?? null,
            $data['externalReference'] ?? null,
            $data['notificationDisabled'] ?? false,
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
        return [
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
            'company' => $this->company,
        ];
    }
}