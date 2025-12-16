<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Comment;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Создаем 15 статей
        Article::factory()->count(15)->create();
        
        // Создаем 50 комментариев
        Comment::factory()->count(50)->create();
    }
}