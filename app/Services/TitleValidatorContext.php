<?php

namespace App\Services;

use App\Interfaces\TitleValidator;

class TitleValidatorContext
{
    private $validator;

    public function __construct(TitleValidator $validator)
    {
        $this->validator = $validator;
    }

    public function setValidator(TitleValidator $validator)
    {
        // Caso em algum contexto futuro o validator possa ser alterado depois de sua construção
        $this->validator = $validator;
    }

    public function validateTitle(string $title): bool
    {
        return $this->validator->validate($title);
    }
}
