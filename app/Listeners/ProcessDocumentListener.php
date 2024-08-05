<?php

namespace App\Listeners;

use App\Events\DocumentUploaded;
use App\Jobs\ProcessDocument;
use App\Services\DocumentValidator;

class ProcessDocumentListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(DocumentUploaded $event): void
    {
        $validator = app(DocumentValidator::class);
        foreach ($event->documentsDTO as $documentDTO) {
            dispatch(new ProcessDocument($documentDTO, $validator));
        }
    }
}
