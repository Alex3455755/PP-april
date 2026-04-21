<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    /**
     * 🔥 Получить текущего пользователя
     */
    public function show()
    {
        return response()->json([
            'success' => true,
            'data' => Auth::user()
        ]);
    }

    /**
     * 🔥 Обновить профиль пользователя
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'login' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'nullable|min:6',
        ]);

        $user->login = $validated['login'];
        $user->email = $validated['email'];

        // если пароль введён — обновляем
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return response()->json([
            'success' => true,
            'data' => $user
        ]);
    }
}