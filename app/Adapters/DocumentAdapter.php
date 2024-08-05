<?php

namespace App\Adapters;

use App\DTO\DocumentDTO;

class DocumentAdapter
{
    public static function adapt(array $document): DocumentDTO
    {
        return new DocumentDTO(
            category: $document['categoria'] ?? null,
            title: $document['titulo'] ?? null,
            contents: $document['conteúdo'] ?? null,
        );
    }

    public static function adaptAll(array $documents): array
    {
        return array_map([self::class, 'adapt'], $documents);
    }
}
