<?php

namespace App\Jobs;

use App\DTO\DocumentDTO;
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
        protected DocumentDTO $documentDTO,
        protected DocumentValidator $validator
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if (!$this->validator->validateMissingField($this->documentDTO)) {
            throw new MissingRequiredFieldsException();
        }

        if (!$this->validator->validateContentLength($this->documentDTO->contents)) {
            throw new ContentLengthExceededException();
        }

        if (!$this->validator->validateTitleByCategory($this->documentDTO->category, $this->documentDTO->title)) {
            throw new InvalidTitleException();
        }

        $category = Category::getByName($this->documentDTO->category);

        DB::beginTransaction();

        try {
            Document::create([
                'category_id' => $category->id,
                'title' => $this->documentDTO->title,
                'contents' => $this->documentDTO->contents,
            ]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception('Erro ao criar documento: ' . $e->getMessage());
        }

        Log::info('Documento processado com sucesso!', ['document' => $this->documentDTO]);
    }
}
