<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')
                  ->constrained()
                  ->onDelete('cascade'); // Каскадное удаление
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained()
                  ->onDelete('set null'); // При удалении пользователя оставляем комментарий
            $table->text('content');
            $table->boolean('is_approved')->default(false); // Для модерации
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};