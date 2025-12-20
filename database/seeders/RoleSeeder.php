<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Создаем роли
        $roles = [
            [
                'name' => 'Модератор',
                'slug' => 'moderator',
                'description' => 'Может управлять статьями и комментариями'
            ],
            [
                'name' => 'Читатель',
                'slug' => 'reader',
                'description' => 'Может читать статьи и оставлять комментарии'
            ]
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(
                ['slug' => $role['slug']],
                $role
            );
        }

        // Создаем модератора
        $moderator = User::firstOrCreate(
            ['email' => 'moderator@example.com'],
            [
                'name' => 'Модератор',
                'password' => Hash::make('password123'),
            ]
        );

        // Назначаем роль модератора
        $moderatorRole = Role::where('slug', 'moderator')->first();
        if ($moderatorRole && !$moderator->hasRole('moderator')) {
            $moderator->roles()->attach($moderatorRole);
        }

        // Всем существующим пользователям назначаем роль читателя
        $readerRole = Role::where('slug', 'reader')->first();
        if ($readerRole) {
            $users = User::whereDoesntHave('roles', function ($query) {
                $query->whereIn('slug', ['reader', 'moderator']);
            })->get();

            foreach ($users as $user) {
                if (!$user->hasRole('moderator')) {
                    $user->roles()->attach($readerRole);
                }
            }
        }

        $this->command->info('Роли созданы и назначены!');
        $this->command->info('Модератор: moderator@example.com / password123');
    }
}