@extends('layouts.app')

@section('title', 'Регистрация')

@section('content')
<div class="max-w-md mx-auto">
    <div class="bg-white border-2 border-[var(--border-color)] shadow-[var(--shadow-medium)] p-8 mb-8">
        <h1 class="text-3xl font-bold mb-6 text-[var(--text-dark)] text-center">
            Регистрация
        </h1>
        
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700">
                {{ session('success') }}
            </div>
        @endif
        
        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700">
                <ul class="list-disc pl-4">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form action="{{ route('auth.register') }}" method="POST" id="registrationForm">
            @csrf
            
            <!-- Поле: Имя -->
            <div class="mb-6">
                <label for="name" class="block text-[var(--text-dark)] font-medium mb-2">
                    Имя <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="name"
                       name="name" 
                       value="{{ old('name') }}"
                       class="w-full border-2 border-[var(--border-color)] px-4 py-3 focus:border-[var(--primary-pink)] focus:outline-none focus:shadow-[var(--shadow-light)] transition-all"
                       placeholder="Введите ваше имя"
                       required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Поле: Email -->
            <div class="mb-6">
                <label for="email" class="block text-[var(--text-dark)] font-medium mb-2">
                    Email <span class="text-red-500">*</span>
                </label>
                <input type="email" 
                       id="email"
                       name="email" 
                       value="{{ old('email') }}"
                       class="w-full border-2 border-[var(--border-color)] px-4 py-3 focus:border-[var(--primary-pink)] focus:outline-none focus:shadow-[var(--shadow-light)] transition-all"
                       placeholder="example@mail.com"
                       required>
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Поле: Пароль -->
            <div class="mb-8">
                <label for="password" class="block text-[var(--text-dark)] font-medium mb-2">
                    Пароль <span class="text-red-500">*</span>
                </label>
                <input type="password" 
                       id="password"
                       name="password" 
                       class="w-full border-2 border-[var(--border-color)] px-4 py-3 focus:border-[var(--primary-pink)] focus:outline-none focus:shadow-[var(--shadow-light)] transition-all"
                       placeholder="Минимум 6 символов"
                       required>
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Кнопка отправки -->
            <div class="mb-6">
                <button type="submit" 
                        class="w-full px-6 py-3 bg-[var(--primary-pink)] text-white font-bold hover:bg-[var(--primary-pink-dark)] transition-colors shadow-[var(--shadow-light)]">
                    Зарегистрироваться
                </button>
            </div>
            
            <!-- Ссылка на главную -->
            <div class="text-center">
                <a href="{{ route('home') }}" 
                   class="text-[var(--primary-pink)] hover:text-[var(--primary-pink-dark)] font-medium">
                    ← Вернуться на главную
                </a>
            </div>
        </form>
        
        <!-- Блок для отображения JSON ответа -->
        <div id="jsonResponse" class="mt-8 hidden">
            <h3 class="text-lg font-bold mb-3 text-[var(--text-dark)]">Ответ сервера (JSON):</h3>
            <pre class="bg-gray-50 border border-gray-200 p-4 rounded text-sm overflow-auto max-h-64"></pre>
        </div>
    </div>

</div>

<!-- JavaScript для обработки формы AJAX -->
<script>
document.getElementById('registrationForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const form = e.target;
    const formData = new FormData(form);
    
    // Показываем загрузку
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn.textContent;
    submitBtn.textContent = 'Отправка...';
    submitBtn.disabled = true;
    
    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        // Показываем JSON ответ
        const jsonResponse = document.getElementById('jsonResponse');
        const pre = jsonResponse.querySelector('pre');
        pre.textContent = JSON.stringify(data, null, 2);
        jsonResponse.classList.remove('hidden');
        
        // Сбрасываем форму если успешно
        if (!data.errors) {
            form.reset();
        }
        
        // Показываем сообщение
        if (data.message) {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Произошла ошибка при отправке формы');
    })
    .finally(() => {
        // Восстанавливаем кнопку
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
    });
});
</script>
@endsection