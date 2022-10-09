<?php

namespace Database\Factories;

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
    public function definition()
    {
        return [
            'user_id' => $this->faker->numberBetween(1, 10),
            'url_process' => $this->faker->url(),
            'cart_id' => $this->faker->numberBetween(1, 10),
            'total' => $this->faker->randomFloat(2, 1, 1000),
            'status' => $this->faker->randomElement(['CREATED', 'PAYED', 'REJECTED']),
            'status_pay' => $this->faker->randomElement(['APPROVED', 'PAYED', 'REJECTED']),
            'request_id' => $this->faker->numberBetween(3000,4000)
        ];
    }
}
