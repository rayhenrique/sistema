<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'birth_date' => $this->faker->optional()->dateTimeBetween('-70 years', '-18 years'),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->optional()->phoneNumber(),
            'document' => $this->faker->unique()->numerify('###.###.###-##'),
            'address' => $this->faker->streetAddress(),
            'city' => $this->faker->city(),
            'state' => strtoupper($this->faker->lexify('??')),
            'postal_code' => $this->faker->postcode(),
            'notes' => $this->faker->optional()->sentence(),
        ];
    }
}
