<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => 1,
            'title' => fake()->title(),
            'description' => fake()->sentence(),
            'content' => fake()->text(),
            'slug' => fake()->slug(), // password
            'image' => fake()->image(),
            'is_promotion' => fake()->boolean(),
            'promotion_ends_at' => fake()->dateTime(now()->addMonths(2)),
            'visible' => fake()->boolean(),
            'fixed' => fake()->boolean(),
            'allow_comments' => fake()->boolean()
        ];
    }
}
