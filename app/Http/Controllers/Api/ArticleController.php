<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index()
    {
        return Article::latest()->paginate(10);
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|min:5|max:200',
            'content' => 'required|string|min:20',
            'short_desc' => 'nullable|string|max:300',
            'is_published' => 'boolean'
        ]);
        
        $article = Article::create([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']) . '-' . rand(1000, 9999),
            'content' => $validated['content'],
            'short_desc' => $validated['short_desc'] ?? null,
            'is_published' => $validated['is_published'] ?? true,
            'user_id' => auth()->id(),
        ]);
        
        return response()->json($article, 201);
    }
    
    public function show(Article $article)
    {
        return $article;
    }
    
    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title' => 'required|string|min:5|max:200',
            'content' => 'required|string|min:20',
            'short_desc' => 'nullable|string|max:300',
            'is_published' => 'boolean'
        ]);
        
        if ($article->title !== $validated['title']) {
            $validated['slug'] = Str::slug($validated['title']) . '-' . rand(1000, 9999);
        }
        
        $article->update($validated);
        
        return response()->json($article);
    }
    
    public function destroy(Article $article)
    {
        $article->delete();
        return response()->json(null, 204);
    }
}