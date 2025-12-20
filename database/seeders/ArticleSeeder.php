<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Comment;
use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        // Получаем роль читателя
        $readerRole = Role::where('slug', 'reader')->first();
        
        // Создаем 5 пользователей с ролью читателя
        for ($i = 1; $i <= 5; $i++) {
            $user = User::factory()->create([
                'name' => "Читатель $i",
                'email' => "reader$i@example.com",
                'password' => Hash::make('password123'),
            ]);
            
            // Назначаем роль читателя
            if ($readerRole && !$user->hasRole('reader')) {
                $user->roles()->attach($readerRole);
            }
        }
        
        // Создаем статьи с разными пользователями
        $articles = Article::factory()->count(15)->create();
        
        // Создаем комментарии к статьям
        foreach ($articles as $article) {
            // 2-5 комментариев на статью
            Comment::factory()->count(rand(2, 5))->create([
                'article_id' => $article->id,
            ]);
        }
        
        $this->command->info('Создано:');
        $this->command->info('- 5 читателей (reader1-5@example.com / password123)');
        $this->command->info('- 15 статей');
        $this->command->info('- 30-75 комментариев');
    }
}