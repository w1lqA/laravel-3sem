<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
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
        
        $token = $user->createToken('api-auth')->plainTextToken;
        
        return response()->json([
            'message' => 'Регистрация успешна',
            'user' => $user,
            'token' => $token
        ], 201);
    }
    
    public function login(Request $request)
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
    
    public function logout(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $user->currentAccessToken()->delete();
            
            return response()->json([
                'message' => 'Выход выполнен'
            ]);
        }
        
        return response()->json([
            'message' => 'Пользователь не авторизован'
        ], 401);
    }
}