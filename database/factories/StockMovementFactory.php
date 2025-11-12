<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StockMovement>
 */
class StockMovementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = $this->faker->randomElement(['inbound', 'outbound', 'adjustment']);

        return [
            'product_id' => Product::factory(),
            'type' => $type,
            'quantity' => $this->faker->numberBetween(1, 50),
            'reference' => strtoupper($this->faker->bothify('MOV-#####')),
            'notes' => $this->faker->optional()->sentence(),
        ];
    }
}
