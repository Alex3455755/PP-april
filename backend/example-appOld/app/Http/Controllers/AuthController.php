<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Регистрация нового пользователя
     * POST /api/register
     */
    public function register(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed',
            ]);

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            // Автоматический вход после регистрации
            Auth::login($user);

            return response()->json([
                'success' => true,
                'message' => 'Регистрация успешна',
                'data' => [
                    'user' => [
                        'id' => $user->id,
                        'login' => $user->login,
                        'email' => $user->email,
                    ]
                ]
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка валидации',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Register error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при регистрации: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Авторизация пользователя
     * POST /api/login
     */
    public function login(Request $request)
{
    $request->validate([
        'email'    => ['required', 'email'],
        'password' => ['required'],
    ]);

    $credentials = $request->only('email', 'password');
    $remember    = $request->has('remember') || false;

    if (Auth::attempt($credentials, $remember)) {
        $user = Auth::user();   // ← Вот здесь получаем пользователя
        
        return response()->json([
            'success' => true,
            'message' => 'Вход выполнен успешно',
            'data'    => [
                'user' => [
                    'id'    => $user->id,
                    'name'  => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                ]
            ]
        ]);
    }

    // Если не удалось войти
    return response()->json([
        'success' => false,
        'message' => 'Неверный email или пароль'
    ], 401);
}

    /**
     * Выход из системы
     * POST /api/logout
     */
    public function logout(Request $request): JsonResponse
    {
        try {
            Auth::logout();
            
            // Инвалидируем сессию
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return response()->json([
                'success' => true,
                'message' => 'Выход выполнен успешно'
            ]);

        } catch (\Exception $e) {
            Log::error('Logout error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при выходе: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Получение информации о текущем пользователе
     * GET /api/user
     */
    public function user(Request $request): JsonResponse
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Пользователь не авторизован'
                ], 401);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'created_at' => $user->created_at
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Get user error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Ошибка получения данных пользователя'
            ], 500);
        }
    }

    /**
     * Проверка статуса авторизации
     * GET /api/check-auth
     */
    public function checkAuth(): JsonResponse
    {
        if (Auth::check()) {
            $user = Auth::user();
            return response()->json([
                'success' => true,
                'authenticated' => true,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email
                ]
            ]);
        }

        return response()->json([
            'success' => true,
            'authenticated' => false
        ]);
    }
}