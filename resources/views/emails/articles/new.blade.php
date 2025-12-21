@component('mail::message')
# Новая статья на сайте {{ config('app.name') }}

**Заголовок:** {{ $article->title }}

**Автор:** {{ $article->user ? $article->user->name : 'Неизвестный автор' }}

**Краткое описание:**
{{ $article->short_desc ?? 'Без описания' }}

**Дата создания:** {{ $article->created_at->format('d.m.Y H:i') }}

@component('mail::button', ['url' => route('articles.show', $article->slug)])
Перейти к статье
@endcomponent

С уважением,<br>
{{ config('app.name') }}
@endcomponent