<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = fake()->randomElement(array_keys(Task::STATUSES));

        return [
            'user_id' => User::factory(),
            'title' => fake()->sentence(4),
            'category' => fake()->randomElement(Task::CATEGORIES),
            'description' => fake()->optional()->paragraph(),
            'priority' => fake()->randomElement(array_keys(Task::PRIORITIES)),
            'status' => $status,
            'due_date' => fake()->dateTimeBetween('-1 week', '+1 month')->format('Y-m-d'),
            'completed_at' => $status === 'done' ? now() : null,
            'is_active' => true,
        ];
    }

    public function done(): static
    {
        return $this->state(fn () => [
            'status' => 'done',
            'completed_at' => now(),
        ]);
    }

    public function pending(): static
    {
        return $this->state(fn () => [
            'status' => 'pending',
            'completed_at' => null,
        ]);
    }

    public function hold(): static
    {
        return $this->state(fn () => [
            'status' => 'hold',
            'completed_at' => null,
        ]);
    }

    public function highPriority(): static
    {
        return $this->state(fn () => ['priority' => 'high']);
    }
}
