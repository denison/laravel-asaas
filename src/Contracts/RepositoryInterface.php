<?php

namespace Denison\AsaasPackage\Contracts;

interface RepositoryInterface
{
    public function create(string $endpoint, array $data = [], array $headers = []): ?array;
    public function update(string $endpoint, array $data = [], array $headers = []): ?array;
    public function find(string $endpoint): ?array;
    public function getAll(string $endpoint): ?array;
}