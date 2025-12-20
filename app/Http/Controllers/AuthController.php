<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // ========== ВЕБ МЕТОДЫ ==========
    public function create()
    {
        return view('auth.signin');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function registration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2|max:50',
            'email' => 'required|email|max:100|unique:users,email',
            'password' => 'required|string|min:6|max:50|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->route('auth.signin')
                ->withErrors($validator)
                ->withInput();
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // redirect на форму авторизации (по заданию ЛР6)
        return redirect()->route('auth.login')
            ->with('success', 'Регистрация прошла успешно! Теперь вы можете войти.');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Создаем токен Sanctum (для API, веб использует сессию)
            $user = Auth::user();
            $user->createToken('web-session');
            
            // redirect на главную форму в обход посредника auth
            return redirect()->route('home')
                ->with('success', 'Вы успешно вошли!');
        }
        
        return back()->withErrors(['email' => 'Неверный email или пароль.']);
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // УДАЛЯЕМ ТОКЕН Sanctum
            $user->tokens()->delete();
        }
        
        // Аннулирование сессии и обновление токена csrf
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('home');
    }
    
    // ========== API МЕТОДЫ ==========
    public function apiRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2|max:50',
            'email' => 'required|email|max:100|unique:users,email',
            'password' => 'required|string|min:6|max:50|confirmed',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        
        // Создаем токен для API
        $token = $user->createToken('api-auth')->plainTextToken;
        
        return response()->json([
            'message' => 'Регистрация успешна',
            'user' => $user,
            'token' => $token
        ], 201);
    }
    
    public function apiLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('api-auth')->plainTextToken;
            
            return response()->json([
                'message' => 'Авторизация успешна',
                'user' => $user,
                'token' => $token
            ]);
        }
        
        return response()->json([
            'message' => 'Неверные учетные данные'
        ], 401);
    }
    
    public function apiLogout(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $user->tokens()->delete();
            
            return response()->json([
                'message' => 'Выход выполнен'
            ]);
        }
        
        return response()->json([
            'message' => 'Пользователь не авторизован'
        ], 401);
    }
}