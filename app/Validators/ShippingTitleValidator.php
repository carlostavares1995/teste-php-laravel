<?php

namespace App\Validators;

use App\Interfaces\TitleValidator;
use App\Services\DocumentValidator;

class ShippingTitleValidator implements TitleValidator
{
    public function validate(string $title): bool
    {
        return str_contains(strtolower($title), DocumentValidator::SEMESTER);
    }
}
