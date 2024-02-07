<?php
// database/factories/ProductFactory.php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory {
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {
        return [
            'code' => $this->faker->unique()->randomNumber(6),
            'date' => $this->faker->date(),
            'name' => $this->faker->word,
        ];
    }
}