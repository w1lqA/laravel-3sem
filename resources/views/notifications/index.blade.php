@extends('layouts.app')

@section('title', 'Мои уведомления')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-[var(--text-dark)]">Мои уведомления</h1>
        <p class="text-[var(--text-light)] mt-2">
            Уведомления о новых статьях
        </p>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded">
            ✅ {{ session('success') }}
        </div>
    @endif

    <div class="bg-white border-2 border-[var(--border-color)] shadow-[var(--shadow-light)] mb-6">
        <div class="p-4 border-b border-[var(--border-color)] flex justify-between items-center">
            <div>
                <span class="font-medium text-[var(--text-dark)]">
                    Всего: {{ $notifications->total() }}
                </span>
                <span class="ml-4 text-[var(--text-light)]">
                    Непрочитанных: {{ auth()->user()->unreadNotifications()->count() }}
                </span>
            </div>
            
            @if(auth()->user()->unreadNotifications()->count() > 0)
            <form action="{{ route('notifications.mark-all-read') }}" method="POST">
                @csrf
                <button type="submit" 
                        class="px-4 py-2 text-sm bg-blue-100 text-blue-700 hover:bg-blue-200 transition-colors">
                    Пометить все как прочитанные
                </button>
            </form>
            @endif
        </div>

        @if($notifications->isEmpty())
        <div class="p-8 text-center text-[var(--text-light)]">
            У вас нет уведомлений
        </div>
        @else
        <div class="divide-y divide-[var(--border-color)]">
            @foreach($notifications as $notification)
            <a href="{{ route('notifications.read', $notification) }}"
               class="block p-4 hover:bg-[#fff5f9] transition-colors {{ $notification->read_at ? 'opacity-80' : 'bg-blue-50' }}">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <div class="font-medium text-[var(--text-dark)] mb-1">
                            {{ $notification->data['article_title'] ?? 'Новая статья' }}
                        </div>
                        <div class="text-sm text-[var(--text-light)]">
                            {{ $notification->data['message'] ?? '' }}
                        </div>
                        <div class="text-xs text-[var(--text-light)] mt-2">
                            {{ $notification->created_at->format('d.m.Y H:i') }}
                            @if(!$notification->read_at)
                            <span class="ml-2 inline-block px-2 py-1 bg-red-100 text-red-700 text-xs rounded">
                                Новое
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="ml-4">
                        <svg class="w-5 h-5 text-[var(--text-light)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        
        @if($notifications->hasPages())
        <div class="p-4 border-t border-[var(--border-color)]">
            {{ $notifications->links() }}
        </div>
        @endif
        @endif
    </div>
</div>
@endsection