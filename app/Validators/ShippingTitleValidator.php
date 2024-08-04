<?php

namespace App\Validators;

use App\Interfaces\TitleValidator;
use App\Models\Document;

class ShippingTitleValidator implements TitleValidator
{
    public function validate(string $title): bool
    {
        return str_contains(strtolower($title), Document::SEMESTER);
    }
}
