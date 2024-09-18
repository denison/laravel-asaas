<?php

namespace Denison\AsaasPackage\Contracts;

interface CustomerInterface
{
    public function getAll();
    public function getById($id);
}