<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\StockMovement;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'Administrador KL',
            'email' => 'admin@klpdv.local',
            'password' => Hash::make('klpdv123'),
            'role' => 'administrador',
        ]);

        User::factory()->create([
            'name' => 'Gerente Comercial',
            'email' => 'gerente@klpdv.local',
            'password' => Hash::make('klpdv123'),
            'role' => 'gerente',
        ]);

        User::factory(3)->create(); // vendedores

        $suppliers = Supplier::factory(5)->create();

        $products = Product::factory(20)
            ->state(fn () => ['supplier_id' => $suppliers->random()->id])
            ->create();

        $products->each(function (Product $product) {
            $initialQuantity = fake()->numberBetween(30, 120);
            $product->update(['stock_quantity' => $initialQuantity]);

            StockMovement::create([
                'product_id' => $product->id,
                'type' => 'inbound',
                'quantity' => $initialQuantity,
                'reference' => 'Estoque inicial',
                'notes' => 'Carga automatizada pelo seed.',
            ]);
        });

        $customers = Customer::factory(30)->create();

        $orders = Order::factory(25)
            ->state(fn () => ['customer_id' => $customers->random()->id])
            ->create();

        $orders->each(function (Order $order) use ($products) {
            $items = OrderItem::factory()
                ->count(fake()->numberBetween(2, 5))
                ->state(function () use ($order, $products) {
                    $product = $products->random();
                    $quantity = fake()->numberBetween(1, 6);
                    $unitPrice = $product->price;
                    $discount = fake()->randomFloat(2, 0, $unitPrice * $quantity * 0.1);

                    return [
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'unit_price' => $unitPrice,
                        'discount' => $discount,
                        'total' => ($unitPrice * $quantity) - $discount,
                    ];
                })
                ->create();

            $items->each(function (OrderItem $item) use ($order) {
                $item->product->decrement('stock_quantity', $item->quantity);

                StockMovement::create([
                    'product_id' => $item->product_id,
                    'type' => 'outbound',
                    'quantity' => $item->quantity,
                    'reference' => "Pedido {$order->code}",
                    'notes' => 'Baixa automatica de estoque.',
                ]);
            });

            $gross = $items->sum(fn (OrderItem $item) => $item->unit_price * $item->quantity);
            $discount = $items->sum('discount');
            $total = max($gross - $discount, 0);

            $status = fake()->randomElement(['pending', 'processing', 'shipped', 'delivered']);
            $shippingStatus = $status === 'delivered' ? 'delivered' : ($status === 'shipped' ? 'in_transit' : 'pending');

            $order->update([
                'status' => $status,
                'shipping_status' => $shippingStatus,
                'subtotal' => $gross,
                'discount' => $discount,
                'total' => $total,
            ]);

            $installments = fake()->numberBetween(1, 3);
            $remaining = $total;
            $paidAmount = 0;

            for ($i = 1; $i <= $installments; $i++) {
                $amount = $i === $installments
                    ? $remaining
                    : round($total / $installments, 2);

                $statusPayment = fake()->randomElement(['pending', 'paid', 'overdue']);
                $paidAt = $statusPayment === 'paid' ? now()->subDays(fake()->numberBetween(0, 20)) : null;

                Payment::create([
                    'order_id' => $order->id,
                    'method' => fake()->randomElement(['pix', 'boleto', 'promissoria', 'dinheiro', 'cartao_credito']),
                    'amount' => $amount,
                    'due_date' => now()->addDays($i * 10),
                    'paid_at' => $paidAt,
                    'status' => $statusPayment,
                    'reference' => "{$order->code}-PARC{$i}",
                    'notes' => $statusPayment === 'overdue' ? 'Parcela em atraso.' : null,
                ]);

                if ($statusPayment === 'paid') {
                    $paidAmount += $amount;
                }

                $remaining = max($remaining - $amount, 0);
            }

            $order->update([
                'payment_status' => $paidAmount >= $total ? 'paid' : ($paidAmount > 0 ? 'partial' : 'pending'),
            ]);
        });

        StockMovement::factory(10)
            ->state(fn () => ['product_id' => $products->random()->id])
            ->create();
    }
}
