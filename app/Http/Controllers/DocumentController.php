<?php

namespace App\Http\Controllers;

use App\Exceptions\DocumentNotFoundException;
use App\Http\Requests\DocumentRequest;
use App\Http\Resources\DocumentResource;
use App\Services\DocumentService;
use App\Traits\HttpResponse;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Exception;

class DocumentController extends Controller
{
    use HttpResponse;

    public function __construct(private DocumentService $documentService)
    {
    }

    public function show()
    {
        return view('document');
    }

    public function upload(DocumentRequest $request)
    {
        try {
            $validRequest = $request->validated();

            $this->documentService->convertDocuments($validRequest['json_file']);

            return $this->success('Documento importado com sucesso!');
        } catch (DocumentNotFoundException $e) {
            return $this->error($e->getMessage());
        } catch (Exception $e) {
            Log::error('Erro ao importar documento!', ['exception' => $e->getMessage()]);
            return $this->error('Erro ao importar documento!');
        }
    }

    public function process()
    {
        // Não e necessario criar um botão para processar o work o correto seria usar o supervisor
        Artisan::call('queue:work', ['--stop-when-empty' => true]);
        return $this->success('Documentos processados com sucesso!');
    }

    public function documentList(Request $request)
    {
        // Um exemplo funcional de como ficaria o retorno usando o Resource
        $documents = $this->documentService->documentList($request);
        return DocumentResource::collection($documents);
    }
}
