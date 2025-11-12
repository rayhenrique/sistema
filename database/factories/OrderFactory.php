<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subtotal = $this->faker->randomFloat(2, 100, 5000);
        $discount = $this->faker->randomFloat(2, 0, $subtotal * 0.15);
        $total = max($subtotal - $discount, 0);
        $status = $this->faker->randomElement(['pending', 'processing', 'shipped', 'delivered']);

        return [
            'code' => strtoupper($this->faker->bothify('PED-#####')),
            'customer_id' => Customer::factory(),
            'status' => $status,
            'shipping_status' => $status === 'shipped' ? 'in_transit' : 'pending',
            'payment_status' => $this->faker->randomElement(['pending', 'partial', 'paid', 'overdue']),
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total' => $total,
            'notes' => $this->faker->optional()->sentence(),
            'expected_shipping_at' => $this->faker->optional()->dateTimeBetween('now', '+7 days'),
            'shipped_at' => $status === 'shipped' ? $this->faker->dateTimeBetween('-3 days', 'now') : null,
            'completed_at' => $status === 'delivered' ? $this->faker->dateTimeBetween('-2 days', 'now') : null,
        ];
    }
}
