<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductAttributes>
 */
class ProductAttributesFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        return [
            'product_id' => Product::factory(), // Updated usage of Product factory
            'color' => $this->faker->colorName,
            'size' => $this->faker->randomElement(['Small', 'Medium', 'Large']),
        ];
    }
}