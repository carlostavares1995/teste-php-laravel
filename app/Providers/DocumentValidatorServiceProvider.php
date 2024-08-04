<?php

namespace App\Providers;

use App\Models\Category;
use App\Services\DocumentValidator;
use App\Validators\PartialShippingTitleValidator;
use App\Validators\ShippingTitleValidator;
use Illuminate\Support\ServiceProvider;

class DocumentValidatorServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(DocumentValidator::class, function ($app) {
            $validators = [
                Category::SHIPPING => new ShippingTitleValidator(),
                Category::PARTIAL_SHIPMENT => new PartialShippingTitleValidator(),
            ];

            return new DocumentValidator($validators);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
