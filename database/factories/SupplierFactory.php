<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supplier>
 */
class SupplierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'tax_id' => $this->faker->unique()->numerify('##.###.###/####-##'),
            'contact_name' => $this->faker->name(),
            'email' => $this->faker->companyEmail(),
            'phone' => $this->faker->phoneNumber(),
            'payment_terms' => $this->faker->randomElement(['15 dias', '30 dias', '45 dias']),
            'address' => $this->faker->streetAddress(),
            'city' => $this->faker->city(),
            'state' => strtoupper($this->faker->lexify('??')),
            'postal_code' => $this->faker->postcode(),
            'notes' => $this->faker->optional()->sentence(),
        ];
    }
}
