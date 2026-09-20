<?php

namespace Database\Factories;

use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<BlogPost>
 */
class BlogPostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->sentence(5);

        return [
            'user_id' => User::factory(),
            'title' => $title,
            'slug' => Str::slug($title).'-'.fake()->unique()->numberBetween(100, 999),
            'excerpt' => fake()->sentence(12),
            'content' => fake()->paragraphs(4, true),
            'cover_image' => null,
            'category' => fake()->randomElement(['Taxation', 'Accounting', 'Compliance']),
            'tags' => fake()->words(3),
            'status' => BlogPost::STATUS_PUBLISHED,
            'is_featured' => false,
            'views' => 0,
            'published_at' => now()->subDays(fake()->numberBetween(1, 30)),
        ];
    }

    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => BlogPost::STATUS_DRAFT,
            'published_at' => null,
        ]);
    }
}
