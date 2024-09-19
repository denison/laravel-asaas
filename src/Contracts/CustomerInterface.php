<?php

namespace Denison\AsaasPackage\Contracts;

interface CustomerInterface
{
    public function getAll(): ?array;
    public function getById($id): ?array;
    public function create(array $data);
}