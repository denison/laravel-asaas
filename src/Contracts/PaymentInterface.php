<?php

namespace Denison\AsaasPackage\Contracts;

interface PaymentInterface
{
    public function create(array $data): ?array;
}