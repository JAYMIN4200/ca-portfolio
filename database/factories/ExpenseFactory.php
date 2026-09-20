<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Expense;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Expense>
 */
class ExpenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_id' => Client::factory(),
            'category' => fake()->randomElement(array_keys(Expense::CATEGORIES)),
            'description' => fake()->sentence(),
            'amount' => fake()->randomFloat(2, 200, 50000),
            'expense_date' => fake()->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
            'method' => fake()->randomElement(['cash', 'bank_transfer', 'upi', 'card']),
            'reference' => strtoupper(fake()->bothify('EXP-####')),
        ];
    }

    public function uncategorized(): static
    {
        return $this->state(fn (array $attributes) => [
            'client_id' => null,
        ]);
    }
}