<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Сначала роли и модератор
        $this->call([
            RoleSeeder::class,
        ]);
        
        // Потом тестовые данные
        $this->call([
            ArticleSeeder::class,
        ]);
    }
}