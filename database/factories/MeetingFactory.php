<?php

namespace Database\Factories;

use App\Models\Meeting;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Meeting>
 */
class MeetingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'client_id' => null,
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->numerify('+91 9#### #####'),
            'title' => fake()->sentence(4),
            'meeting_date' => fake()->dateTimeBetween('now', '+1 month')->format('Y-m-d'),
            'start_time' => fake()->randomElement(['10:00', '11:30', '14:00', '16:30']),
            'end_time' => null,
            'type' => fake()->randomElement(array_keys(Meeting::TYPES)),
            'location' => null,
            'status' => 'pending',
            'notes' => fake()->sentence(),
        ];
    }
}
