<?php

namespace App\Services;

use App\Jobs\ProcessDocument;
use App\Services\DocumentValidator;

class DocumentService
{
    public function addDocumentToQueue($jsonFile): void
    {
        $data = json_decode(file_get_contents($jsonFile), true);

        if (isset($data['documentos']) && is_array($data['documentos'])) {
            $validator = app(DocumentValidator::class);
            foreach ($data['documentos'] as $document) {
                dispatch(new ProcessDocument($document, $validator));
            }
        }
    }
}
