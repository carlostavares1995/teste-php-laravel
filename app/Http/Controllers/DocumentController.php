<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentRequest;
use App\Services\DocumentService;
use App\Traits\HttpResponse;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
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

            $this->documentService->addDocumentToQueue($validRequest['json_file']);

            return $this->success('Documentos enviados com sucesso!');
        } catch (Exception $e) {
            Log::error('Erro ao enviar documentos!', ['exception' => $e->getMessage()]);
            return $this->error('Erro ao enviar documentos!');
        }
    }

    public function process()
    {
        // Não e necessario criar um botão para processar o work o correto seria usar o supervisor
        Artisan::call('queue:work', ['--stop-when-empty' => true]);
        return $this->success('Documentos processados com sucesso!');
    }
}
