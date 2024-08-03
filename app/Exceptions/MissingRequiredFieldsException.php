<?php

namespace App\Exceptions;

use Exception;

class MissingRequiredFieldsException extends Exception
{
    protected $message = 'Campos obrigatórios ausentes!';

    public function __construct()
    {
        parent::__construct($this->message);
    }
}
