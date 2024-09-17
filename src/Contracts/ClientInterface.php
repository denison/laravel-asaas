<?php

namespace Denison\AsaasPackage\Contracts;

interface ClienteInterface
{
    public function getAll();
    public function getById($id);
}