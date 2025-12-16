<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::published()->latest()->paginate(6);
        return view('articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Пока не нужно для ЛР №4
        return redirect()->route('articles.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Пока не нужно для ЛР №4
        return redirect()->route('articles.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        // Увеличиваем счетчик просмотров
        $article->increment('views_count');
        
        return view('articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        // Пока не нужно для ЛР №4
        return redirect()->route('articles.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        // Пока не нужно для ЛР №4
        return redirect()->route('articles.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        // Пока не нужно для ЛР №4
        return redirect()->route('articles.index');
    }
}