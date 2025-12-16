<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'preview_image',
        'full_image',
        'short_desc',
        'is_published',
        'views_count'
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Скоупы для удобства
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopePopular($query)
    {
        return $query->orderBy('views_count', 'desc');
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}