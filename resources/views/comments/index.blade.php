@extends('layouts.app')

@section('title', 'Комментарии')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-bold mb-2 text-gray-800">Все комментарии</h1>
        <p class="text-gray-600">
            Управление комментариями. Показано {{ $comments->total() }} комментариев.
        </p>
    </div>
    
    @if($comments->isEmpty())
        <div class="bg-white border-2 border-gray-200 p-8 text-center">
            <p class="text-gray-600">Комментарии не найдены</p>
        </div>
    @else
        <!-- Таблица комментариев -->
        <div class="bg-white border-2 border-gray-200 shadow-lg overflow-hidden mb-6">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Статья</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Комментарий</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Статус</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Дата</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Действия</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($comments as $comment)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $comment->id }}
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('articles.show', $comment->article->slug) }}" 
                               class="text-pink-600 hover:text-pink-800 text-sm font-medium">
                                {{ Str::limit($comment->article->title, 30) }}
                            </a>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">
                                {{ Str::limit($comment->content, 50) }}
                            </div>
                            @if($comment->user)
                            <div class="text-xs text-gray-500">
                                Автор: {{ $comment->user->name }}
                            </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs rounded-full {{ $comment->is_approved ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $comment->is_approved ? 'Одобрен' : 'На модерации' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $comment->created_at->format('d.m.Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex gap-2">
                                <a href="{{ route('comments.show', $comment) }}" 
                                class="text-blue-600 hover:text-blue-900">Просмотр</a>
                                
                                @can('approve', $comment)
                                    @if(!$comment->is_approved)
                                    <form action="{{ route('comments.approve', $comment) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-green-600 hover:text-green-900">Одобрить</button>
                                    </form>
                                    @endif
                                @endcan
                                
                                @can('delete', $comment)
                                <form action="{{ route('comments.destroy', $comment) }}" method="POST" 
                                    onsubmit="return confirm('Удалить комментарий?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Удалить</button>
                                </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Пагинация -->
        {{ $comments->links() }}
    @endif
    
    <!-- Ссылка на создание -->
    <div class="mt-8">
        <a href="{{ route('comments.create') }}" 
           class="px-6 py-3 bg-pink-600 text-white font-bold hover:bg-pink-700 transition-colors shadow-lg inline-flex items-center gap-2">
            ✍️ Добавить комментарий
        </a>
    </div>
</div>
@endsection