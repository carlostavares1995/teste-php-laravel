<?php

namespace App\Services;

use App\DTO\DocumentDTO;
use App\Models\Document;
use App\Services\TitleValidatorContext;

class DocumentValidator
{
    public function __construct(protected array $validators)
    {
    }

    public function validateMissingField(DocumentDTO $documentDTO): bool
    {
        return !is_null($documentDTO->category) && !is_null($documentDTO->title) && !is_null($documentDTO->contents);
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
