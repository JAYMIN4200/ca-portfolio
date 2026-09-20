<?php

namespace Database\Factories;

use App\Models\CaseStudy;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<CaseStudy>
 */
class CaseStudyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->sentence(4);

        return [
            'user_id' => User::factory(),
            'title' => $title,
            'slug' => Str::slug($title).'-'.fake()->unique()->numberBetween(100, 999),
            'client_name' => fake()->company(),
            'category' => fake()->randomElement(['Audit', 'Taxation', 'GST', 'Advisory']),
            'summary' => fake()->paragraph(),
            'challenge' => fake()->paragraph(),
            'solution' => fake()->paragraph(),
            'results' => fake()->paragraph(),
            'image_path' => null,
            'is_active' => true,
            'display_order' => 0,
            'published_at' => now()->subDays(fake()->numberBetween(1, 30))->toDateString(),
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
