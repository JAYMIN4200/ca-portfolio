<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\ClientWork;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ClientWork>
 */
class ClientWorkFactory extends Factory
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
            'title' => fake()->sentence(4),
            'description' => fake()->paragraph(),
            'work_date' => fake()->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
            'amount' => fake()->randomFloat(2, 1000, 50000),
            'status' => fake()->randomElement(array_keys(ClientWork::STATUSES)),
        ];
    }
}
