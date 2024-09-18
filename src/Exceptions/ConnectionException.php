<?php

namespace Denison\AsaasPackage\Exceptions;

use Exception;

class ConnectionException extends Exception
{
    protected $message = 'Erro de conexão com a API.';
}