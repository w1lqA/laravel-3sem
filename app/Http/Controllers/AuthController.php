<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /**
     * Показываем форму регистрации
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Регистрация нового пользователя
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2|max:50',
            'email' => 'required|email|max:100|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Создание пользователя
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => User::ROLE_READER,
        ]);

        // ✅ ЛР №6: redirect на форму авторизации после регистрации
        return redirect()->route('auth.login')
            ->with('success', 'Регистрация успешна! Теперь вы можете войти.');
    }

    /**
     * Показываем форму авторизации
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Авторизация пользователя с Sanctum токеном
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            // ✅ ЛР №6: Создаем токен аутентификации Sanctum
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;
            
            // Сохраняем токен в сессии для использования
            Session::put('sanctum_token', $token);
            
            // ✅ ЛР №6: redirect на главную В ОБХОД посредника auth
            return redirect()->intended(route('home'))
                ->with('success', 'Вы успешно вошли в систему!')
                ->with('sanctum_token', $token); // Передаем токен во flash сессии
        }

        return back()->withErrors([
            'email' => 'Неверные учетные данные.',
        ])->onlyInput('email');
    }

    /**
     * Выход пользователя с удалением токена Sanctum
     */
    public function logout(Request $request)
    {
        // Удаляем Sanctum токены если есть
        if (Auth::check()) {
            $request->user()->currentAccessToken()?->delete();
        }
        
        // Стандартный выход
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('home')
            ->with('success', 'Вы успешно вышли из системы.');
    }
    /**
     * Старые методы для ЛР №3 (оставляем для совместимости)
     */
    public function create()
    {
        return view('auth.signin');
    }

    public function registration(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|min:2|max:50',
                'email' => 'required|email|max:100',
                'password' => 'required|string|min:6|max:50'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ошибка валидации',
                    'errors' => $validator->errors()
                ], 422);
            }

            return response()->json([
                'success' => true,
                'message' => 'Демо-регистрация (ЛР №3)',
                'user' => [
                    'name' => $request->name,
                    'email' => $request->email
                ],
                'csrf_token' => csrf_token()
            ]);
        }

        return redirect()->route('auth.register');
    }
}