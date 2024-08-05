<?php

namespace App\Services;

use App\Adapters\DocumentAdapter;
use App\Events\DocumentUploaded;
use App\Exceptions\DocumentNotFoundException;
use App\Models\Document;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class DocumentService
{
    public function convertDocuments($jsonFile): void
    {
        $data = json_decode(file_get_contents($jsonFile), true);

        if (!isset($data['documentos']) || !is_array($data['documentos'])) {
            throw new DocumentNotFoundException('O arquivo importado não contém a chave "documentos" ou está formatado incorretamente!');
        }

        if (empty($data['documentos'])) {
            throw new DocumentNotFoundException('Nenhum documento foi encontrado no arquivo importado!');
        }

        $documentsDTO = DocumentAdapter::adaptAll($data['documentos']);
        event(new DocumentUploaded($documentsDTO));
    }

    public function documentList(Request $request): LengthAwarePaginator
    {
        // Um exemplo funcional de como ficaria uma consulta paginada para documentos
        $perPage = $request->per_page ?? 10;

        // Podemos utilizar um cache aqui para melhorar o desempenho
        // Limpando sua key quando um novo documento for criado ou editado
        $documents = Document::with('category')->paginate($perPage);

        return $documents;
    }
}
