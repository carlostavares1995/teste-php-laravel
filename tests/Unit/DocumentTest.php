<?php

namespace Tests\Unit;

use App\Models\Document;
use App\Services\DocumentValidator;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class DocumentTest extends TestCase
{
    protected DocumentValidator $documentValidator;

    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed');
        $this->documentValidator = app(DocumentValidator::class);
    }

    public function test_content_length_success(): void
    {
        $document = Document::factory()->make()->toArray();

        $result = $this->documentValidator->validateContentLength($document['contents']);

        $this->assertTrue($result);
    }

    public function test_content_length_failed(): void
    {
        $document = Document::factory()->largeContent()->make()->toArray();

        $result = $this->documentValidator->validateContentLength($document['contents']);

        $this->assertFalse($result);
    }

    public function test_shipping_title_success(): void
    {
        $document = Document::factory()->shippingCategory()->addSemester()->make()->toArray();

        $result = $this->documentValidator->validateTitleByCategory(
            $document['category_name'],
            $document['title']
        );

        $this->assertTrue($result);
    }

    public function test_shipping_title_failed(): void
    {
        $document = Document::factory()->shippingCategory()->make()->toArray();

        $result = $this->documentValidator->validateTitleByCategory(
            $document['category_name'],
            $document['title']
        );

        $this->assertFalse($result);
    }

    public function test_partial_shipping_title_success(): void
    {
        $document = Document::factory()->partialShipmentCategory()->addMonth()->make()->toArray();

        $result = $this->documentValidator->validateTitleByCategory(
            $document['category_name'],
            $document['title']
        );

        $this->assertTrue($result);
    }

    public function test_partial_shipping_title_failed(): void
    {
        $document = Document::factory()->partialShipmentCategory()->make()->toArray();

        $result = $this->documentValidator->validateTitleByCategory(
            $document['category_name'],
            $document['title']
        );

        $this->assertFalse($result);
    }
}
