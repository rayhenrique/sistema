<?php

namespace Database\Factories;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
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
        $cost = $this->faker->randomFloat(2, 5, 500);
        $margin = $this->faker->numberBetween(10, 60);
        $price = round($cost * (1 + ($margin / 100)), 2);

        return [
            'supplier_id' => Supplier::factory(),
            'sku' => strtoupper($this->faker->bothify('PRD-#####')),
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->sentence(),
            'price' => $price,
            'cost' => $cost,
            'margin' => $margin,
            'stock_quantity' => $this->faker->numberBetween(0, 200),
            'stock_minimum' => $this->faker->numberBetween(5, 30),
            'is_active' => true,
        ];
    }
}
