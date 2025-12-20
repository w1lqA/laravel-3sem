<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        return Comment::with(['article', 'user'])->latest()->paginate(20);
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'article_id' => 'required|exists:articles,id',
            'content' => 'required|string|min:5|max:1000'
        ]);
        
        $comment = Comment::create([
            'article_id' => $validated['article_id'],
            'user_id' => auth()->id(),
            'content' => $validated['content'],
            'is_approved' => false
        ]);
        
        return response()->json($comment, 201);
    }
    
    public function show(Comment $comment)
    {
        return $comment->load(['article', 'user']);
    }
    
    public function update(Request $request, Comment $comment)
    {
        if ($comment->user_id !== auth()->id()) {
            return response()->json(['message' => 'Нет прав'], 403);
        }
        
        $validated = $request->validate([
            'content' => 'required|string|min:5|max:1000'
        ]);
        
        $comment->update([
            'content' => $validated['content'],
            'is_approved' => false
        ]);
        
        return response()->json($comment);
    }
    
    public function destroy(Comment $comment)
    {
        if ($comment->user_id !== auth()->id()) {
            return response()->json(['message' => 'Нет прав'], 403);
        }
        
        $comment->delete();
        return response()->json(null, 204);
    }
}