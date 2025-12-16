<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'article_id' => Article::inRandomOrder()->first()->id ?? Article::factory(),
            'user_id' => null, // Пока без пользователей
            'content' => $this->faker->paragraphs(rand(1, 3), true),
            'is_approved' => $this->faker->boolean(70), // 70% комментариев одобрены
            'created_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
        ];
    }
}