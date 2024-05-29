<?php

namespace Database\Factories;

use App\Enums\ProductType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cabang>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => $this->faker->unique()->numerify('PRD-####'),
            'name' => 'Produk ' . $this->faker->numerify('####'),
            'description' => $this->faker->realText(),
            'photo' => 'default/16x9.png',
            'price' => $this->faker->numberBetween(1000, 400000),
            'type' => $this->faker->randomElement(ProductType::values()),
        ];
    }
}
