<?php

namespace App\Providers;

use App\Enums\CategoryType;
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
                CategoryType::SHIPPING->value => new ShippingTitleValidator(),
                CategoryType::PARTIAL_SHIPMENT->value => new PartialShippingTitleValidator(),
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
