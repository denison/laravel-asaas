<?php

namespace Denison\AsaasPackage\Contracts;

interface ClientInterface
{
    public function getAll();
    public function getById($id);
}