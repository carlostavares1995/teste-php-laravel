<?php

namespace App\Jobs;

use App\Exceptions\ContentLengthExceededException;
use App\Exceptions\InvalidTitleException;
use App\Exceptions\MissingRequiredFieldsException;
use App\Models\Category;
use App\Models\Document;
use App\Services\DocumentValidator;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Exception;

class ProcessDocument implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected array $document,
        protected DocumentValidator $validator
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $requiredFields = ['categoria', 'titulo', 'conteúdo'];
        $missingFields = array_diff($requiredFields, array_keys($this->document));
        if (!empty($missingFields)) {
            throw new MissingRequiredFieldsException();
        }

        if (!$this->validator->validateContentLength($this->document['conteúdo'])) {
            throw new ContentLengthExceededException();
        }

        if (!$this->validator->validateTitleByCategory($this->document['categoria'], $this->document['titulo'])) {
            throw new InvalidTitleException();
        }

        $category = Category::getByName($this->document['categoria']);

        DB::beginTransaction();

        try {
            Document::create([
                'category_id' => $category->id,
                'title' => $this->document['titulo'],
                'contents' => $this->document['conteúdo']
            ]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception('Erro ao criar documento: ' . $e->getMessage());
        }

        Log::info('Documento processado com sucesso!', ['document' => $this->document]);
    }
}
