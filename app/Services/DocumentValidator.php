<?php

namespace App\Services;

use App\Models\Document;
use App\Services\TitleValidatorContext;

class DocumentValidator
{
    public function __construct(protected array $validators)
    {
    }

    public function validateContentLength(string $content): bool
    {
        return strlen($content) <= Document::MAX_CONTENT_LENGTH;
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
