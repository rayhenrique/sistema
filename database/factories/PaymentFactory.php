<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories.Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $amount = $this->faker->randomFloat(2, 50, 5000);
        $status = $this->faker->randomElement(['pending', 'paid', 'overdue', 'cancelled']);
        $paidAt = $status === 'paid' ? $this->faker->dateTimeBetween('-15 days', 'now') : null;

        return [
            'order_id' => Order::factory(),
            'method' => $this->faker->randomElement(['pix', 'boleto', 'promissoria', 'dinheiro', 'cartao_credito', 'cartao_debito']),
            'amount' => $amount,
            'due_date' => $this->faker->dateTimeBetween('-10 days', '+30 days'),
            'paid_at' => $paidAt,
            'status' => $status,
            'reference' => strtoupper($this->faker->bothify('REC-#####')),
            'notes' => $this->faker->optional()->sentence(),
        ];
    }
}
