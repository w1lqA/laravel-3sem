<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ArticleFactory extends Factory
{
    protected $model = Article::class;

    public function definition(): array
    {
        $title = $this->faker->sentence(rand(3, 8));
        
        return [
            'title' => $title,
            'slug' => Str::slug($title) . '-' . rand(1000, 9999),
            'content' => $this->faker->paragraphs(rand(3, 8), true),
            'short_desc' => $this->faker->paragraph(rand(1, 2)),
            'user_id' => User::factory(), // Создает нового пользователя
            'is_published' => $this->faker->boolean(90), // 90% опубликованы
            'views_count' => $this->faker->numberBetween(0, 1000),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }

    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_published' => true,
        ]);
    }

    public function unpublished(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_published' => false,
        ]);
    }
}