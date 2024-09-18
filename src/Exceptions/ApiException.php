<?php

namespace Denison\AsaasPackage\Exceptions;

use Exception;

class ApiException extends Exception
{
    protected $message = 'Erro na resposta da API.';
}