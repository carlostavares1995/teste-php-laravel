<?php

namespace App\Interfaces;

interface TitleValidator
{
    public function validate(string $title): bool;
}
