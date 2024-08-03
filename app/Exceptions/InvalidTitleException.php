<?php

namespace App\Exceptions;

use Exception;

class InvalidTitleException extends Exception
{
    protected $message = 'Registro inválido!';

    public function __construct()
    {
        parent::__construct($this->message);
    }
}
