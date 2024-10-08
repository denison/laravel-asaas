<?php

namespace Denison\AsaasPackage\Contracts;

interface CustomerInterface
{
    public function getAll(): ?array;
    public function getById($id): ?array;
    public function create(array $data): ?array;
    public function update(string $id,  array $data = []): ?array;
}