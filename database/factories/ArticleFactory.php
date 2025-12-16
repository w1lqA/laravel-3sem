<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    public function definition(): array
    {
        $title = $this->faker->sentence(rand(3, 6));
        
        return [
            'title' => $title,
            'slug' => Str::slug($title) . '-' . rand(1000, 9999),
            'content' => $this->faker->paragraphs(rand(3, 8), true),
            'preview_image' => 'preview_' . rand(1, 3) . '.jpg',
            'full_image' => 'full_' . rand(1, 3) . '.jpeg',
            'short_desc' => $this->faker->sentence(rand(8, 12)),
            'is_published' => $this->faker->boolean(80), // 80% статей опубликованы
            'views_count' => $this->faker->numberBetween(0, 1000),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}