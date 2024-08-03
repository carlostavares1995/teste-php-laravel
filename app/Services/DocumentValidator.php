<?php

namespace App\Services;

use App\Services\TitleValidatorContext;

class DocumentValidator
{
    // Criei os valores constantes aqui mais poreriamos ter criado em algum arquivo global
    const MAX_CONTENT_LENGTH = 5000;
    const SEMESTER = 'semestre';
    const CATEGORY_SHIPPING = 'Remessa';
    const CATEGORY_PARTIAL_SHIPMENT = 'Remessa Parcial';

    public function __construct(protected array $validators)
    {
    }

    public function validateContentLength(string $content): bool
    {
        return strlen($content) <= self::MAX_CONTENT_LENGTH;
    }

    public function validateTitleByCategory(string $category, string $title): bool
    {
        if (isset($this->validators[$category])) {
            // Usei o padrão strategy para facilitar novas validações de titulo
            $titleValidatorContext = new TitleValidatorContext($this->validators[$category]);
            return $titleValidatorContext->validateTitle($title);
        }

        return false;
    }
}
