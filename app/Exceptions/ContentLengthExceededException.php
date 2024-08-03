<?php

namespace App\Exceptions;

use Exception;

class ContentLengthExceededException extends Exception
{
    protected $message = 'Conteúdo muito longo!';

    public function __construct()
    {
        parent::__construct($this->message);
    }
}
