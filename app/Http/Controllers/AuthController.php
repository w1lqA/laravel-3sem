<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Показываем форму регистрации
     */
    public function create()
    {
        return view('auth.signin');
    }
    
    /**
     * Обрабатываем регистрацию
     */
    public function registration(Request $request)
    {
        // Правила валидации
        $rules = [
            'name' => 'required|string|min:2|max:50',
            'email' => 'required|email|max:100',
            'password' => 'required|string|min:6|max:50'
        ];
        
        // Сообщения об ошибках
        $messages = [
            'name.required' => 'Поле "Имя" обязательно для заполнения.',
            'name.min' => 'Имя должно содержать минимум 2 символа.',
            'name.max' => 'Имя должно содержать максимум 50 символов.',
            
            'email.required' => 'Поле "Email" обязательно для заполнения.',
            'email.email' => 'Введите корректный email адрес.',
            'email.max' => 'Email должен содержать максимум 100 символов.',
            
            'password.required' => 'Поле "Пароль" обязательно для заполнения.',
            'password.min' => 'Пароль должен содержать минимум 6 символов.',
            'password.max' => 'Пароль должен содержать максимум 50 символов.'
        ];
        
        // Валидация
        $validator = Validator::make($request->all(), $rules, $messages);
        
        if ($validator->fails()) {
            // Возвращаем ошибки валидации в JSON
            return response()->json([
                'success' => false,
                'message' => 'Ошибка валидации',
                'errors' => $validator->errors()
            ], 422);
        }
        
        // Если валидация прошла успешно
        // В реальном приложении здесь была бы сохранение в БД
        $validatedData = $validator->validated();
        
        // Симуляция создания пользователя (без сохранения в БД)
        $userData = [
            'id' => rand(1000, 9999), // временный ID
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password_hash' => '***скрыто***', // В реальности: Hash::make($validatedData['password'])
            'created_at' => now()->toDateTimeString(),
            'updated_at' => now()->toDateTimeString()
        ];
        
        // Возвращаем успешный JSON ответ
        return response()->json([
            'success' => true,
            'message' => 'Регистрация прошла успешно! (Демо-режим)',
            'user' => $userData,
            'validation_passed' => true,
            'csrf_token' => csrf_token(),
            'received_data' => [
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password_length' => strlen($validatedData['password'])
            ]
        ], 200);
    }
}