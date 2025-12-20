@extends('layouts.app')

@section('title', 'О нас')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white border-2 border-[var(--border-color)] shadow-[var(--shadow-medium)] p-8 mb-8">
        <h1 class="text-3xl font-bold mb-6 text-[var(--text-dark)] border-b-2 border-[var(--border-color)] pb-3">
            О нашем проекте
        </h1>
        
        <div class="space-y-6">
            <div>
                <p class="text-[var(--text-light)]">Этот сайт разработан в рамках выполнения лабораторных работ по курсу "Серверная веб-разработка". Основная цель — освоить фреймворк Laravel на практике.</p>
            </div>
        </div>
    </div>
</div>
@endsection