<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Создаем модератора
        User::create([
            'name' => 'Модератор',
            'email' => 'moderator@example.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_MODERATOR,
        ]);

        // Создаем обычного читателя
        User::create([
            'name' => 'Читатель',
            'email' => 'reader@example.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_READER,
        ]);

        // Создаем еще 5 пользователей
        User::factory()->count(5)->create();

        // Создаем статьи
        Article::factory()->count(15)->create();

        // Создаем комментарии
        Comment::factory()->count(50)->create();
    }
}