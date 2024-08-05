<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\Category;
use App\Enums\CategoryType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Document>
 */
class DocumentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $category = Category::inRandomOrder()->firstOrFail();

        return [
            'category_id' => $category->id,
            'category_name' => $category->name,
            'title' => fake()->sentence(3),
            'contents' => fake()->paragraph(),
        ];
    }

    public function shippingCategory(): Factory
    {
        return $this->state(function (array $attributes) {
            $category = Category::getByName(CategoryType::SHIPPING->value);

            return [
                'category_id' => $category->id,
                'category_name' => $category->name,
            ];
        });
    }

    public function partialShipmentCategory(): Factory
    {
        return $this->state(function (array $attributes) {
            $category = Category::getByName(CategoryType::PARTIAL_SHIPMENT->value);

            return [
                'category_id' => $category->id,
                'category_name' => $category->name,
            ];
        });
    }

    public function largeContent(): Factory
    {
        return $this->state(fn () => [
            'contents' => fake()->realText(6000),
        ]);
    }

    public function addSemester(): Factory
    {
        return $this->state(fn (array $attributes) => [
            'title' => $attributes['title'] . ' semestre',
        ]);
    }

    public function addMonth(): Factory
    {
        return $this->state(function (array $attributes) {
            Carbon::setLocale('pt_BR');
            $randomMonth = Carbon::createFromFormat('m', rand(1, 12))->translatedFormat('F');

            return [
                'title' => $attributes['title'] . ' ' . $randomMonth,
            ];
        });
    }
}
